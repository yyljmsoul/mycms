<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SwitchSessionLang
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($sysLang = system_lang()) {

            if ($lang = $request->input('lang')) {

                set_current_lang(in_array($lang, array_keys($sysLang)) ? $lang : null);

            } else {

                if (empty(current_lang())) {

                    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {

                        $clientLang = mb_substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2, 'utf-8');

                        if (in_array($clientLang, array_keys($sysLang))) {

                            set_current_lang($clientLang);
                        }

                    } else {

                        set_current_lang(system_default_lang());
                    }
                }

            }
        }

        return $next($request);
    }
}
