<?php

/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */

class DefaultAcsClient implements IAcsClient
{
    public $iClientProfile;

    function __construct($iClientProfile)
    {
        $this->iClientProfile = $iClientProfile;
    }

    /**
     * @throws ServerException
     * @throws ClientException
     */
    public function getAcsResponse($request, $iSigner = null, $credential = null, $autoRetry = true, $maxRetryNumber = 3)
    {
        $httpResponse = $this->doAction($request, $iSigner, $credential, $autoRetry, $maxRetryNumber);
        $respObject = $this->parseAcsResponse($httpResponse->getBody(), $request->getAcceptFormat());

        if (!$httpResponse->isSuccess()) {

            $this->buildApiException($respObject, $httpResponse->getStatus());
        }

        return $respObject;
    }

    public function doAction($request, $iSigner = null, $credential = null, $autoRetry = true, $maxRetryNumber = 3)
    {
        if (null == $this->iClientProfile && (null == $iSigner || null == $credential
                || null == $request->getRegionId() || null == $request->getAcceptFormat())) {
            throw new ClientException("No active profile found.", "SDK.InvalidProfile");
        }
        if (null == $iSigner) {
            $iSigner = $this->iClientProfile->getSigner();
        }
        if (null == $credential) {
            $credential = $this->iClientProfile->getCredential();
        }
        $request = $this->prepareRequest($request);
        $domain = EndpointProvider::findProductDomain($request->getRegionId(), $request->getProduct());
        if (null == $domain) {
            throw new ClientException("Can not find endpoint to access.", "SDK.InvalidRegionId");
        }
        $requestUrl = $request->composeUrl($iSigner, $credential, $domain);
        if (count($request->getDomainParameter()) > 0) {
            $httpResponse = HttpHelper::curl($requestUrl, $request->getMethod(), $request->getDomainParameter(), $request->getHeaders());
        } else {
            $httpResponse = HttpHelper::curl($requestUrl, $request->getMethod(), null, $request->getHeaders());
        }

        $retryTimes = 1;
        while (500 <= $httpResponse->getStatus() && $autoRetry && $retryTimes < $maxRetryNumber) {
            $requestUrl = $request->composeUrl($iSigner, $credential, $domain);

            if (count($request->getDomainParameter()) > 0) {
                $httpResponse = HttpHelper::curl($requestUrl, $request->getDomainParameter(), $request->getHeaders());
            } else {
                $httpResponse = HttpHelper::curl($requestUrl, $request->getMethod(), null, $request->getHeaders());
            }
            $retryTimes++;
        }
        return $httpResponse;
    }

    private function prepareRequest($request)
    {
        if (null == $request->getRegionId()) {
            $request->setRegionId($this->iClientProfile->getRegionId());
        }
        if (null == $request->getAcceptFormat()) {
            $request->setAcceptFormat($this->iClientProfile->getFormat());
        }
        if (null == $request->getMethod()) {
            $request->setMethod("GET");
        }
        return $request;
    }


    private function buildApiException($respObject, $httpStatus)
    {
        if (500 <= $httpStatus) {
            throw new ServerException($respObject->Message, $respObject->Code);
        } else {
            throw new ClientException($respObject->Message, $respObject->Code);
        }
    }

    private function parseAcsResponse($body, $format)
    {
        if ("JSON" == $format) {
            $respObject = json_decode($body);
        } else if ("XML" == $format) {
            $respObject = @simplexml_load_string($body);
        } else if ("RAW" == $format) {
            $respObject = $body;
        }
        return $respObject;
    }
}
