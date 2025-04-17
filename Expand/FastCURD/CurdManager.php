<?php


namespace Expand\FastCURD;


use Doctrine\DBAL\Types\TextType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class CurdManager
{

    /**
     * 全小写名称
     *
     * @var string
     */
    protected $lowerName = '';

    /**
     * 驼峰名称
     *
     * @var string
     */
    protected $camelName = '';

    /**
     * 模块名称
     *
     * @var string
     */
    protected $moduleName = '';

    /**
     * 表名
     * @var string
     */
    protected $table = '';

    /**
     * 表字段名称
     * @var array
     */
    protected $fields = [];

    /**
     * 多语言
     * @var bool
     */
    protected $lang = false;


    /**
     * 多语言
     * @var bool
     */
    protected $alias = false;

    public function __construct($table, $module, $lang = false, $alias = '')
    {
        $this->lang = $lang;
        $this->table = $table;
        $this->moduleName = $module;

        $this->lowerName = $alias ?: str_replace('my_', '', $table);

        $this->camelName = join("", array_map(function ($item) {
            return ucfirst($item);
        }, explode("_", $this->lowerName)));

    }

    /**
     * @throws \Doctrine\DBAL\Exception
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function handle()
    {
        $this->fields = $this->getTableFields();

        $this->classHandle();
        $this->bladeHandle();
        $this->routeHandle();
    }

    /**
     * 类生成
     */
    protected function classHandle()
    {
        $this->controllerStub();
        $this->modelStub();
        $this->requestStub();
    }

    /**
     * 模板生成
     */
    protected function bladeHandle()
    {
        $this->indexBladeStub();
        $this->createBladeStub();
        $this->editBladeStub();
    }

    /**
     * @throws \Doctrine\DBAL\Schema\SchemaException
     * @throws \Doctrine\DBAL\Exception
     */
    protected function getTableFields(): array
    {
        $columns = Schema::getColumnListing($this->table);

        $columns = array_diff($columns, ["updated_at", "created_at"]);
        $obj = DB::connection()->getDoctrineSchemaManager()
            ->listTableDetails($this->table);

        $data = [];

        foreach ($columns as $value) {
            if (!in_array($value, ['id', 'lang', 'lang_ident'])) {
                $data[] = $obj->getColumn($value)->toArray();
            }
        }

        return $data;
    }

    /**
     * 生成控制器
     */
    protected function controllerStub()
    {
        $fileName = $this->lang ? 'Controller-lang.stub' : 'Controller.stub';
        $content = file_get_contents(base_path('Expand/FastCURD/stubs/' . $fileName));

        $content = str_replace([
            '{module}', '{camel}', '{lower}'
        ], [
            $this->moduleName, $this->camelName, $this->lowerName
        ], $content);

        $path = "Modules/{$this->moduleName}/Http/Controllers/Admin/{$this->camelName}Controller.php";

        Storage::disk('root')->put($path, $content);
    }

    /**
     * 模型
     */
    protected function modelStub()
    {
        $content = file_get_contents(base_path('Expand/FastCURD/stubs/Model.stub'));

        $content = str_replace([
            '{module}', '{camel}', '{table}'
        ], [
            $this->moduleName, $this->camelName, $this->table
        ], $content);

        $path = "Modules/{$this->moduleName}/Models/{$this->camelName}Model.php";

        Storage::disk('root')->put($path, $content);
    }

    /**
     * 请求类
     */
    protected function requestStub()
    {
        $content = file_get_contents(base_path('Expand/FastCURD/stubs/Request.stub'));

        $content = str_replace([
            '{module}', '{camel}', '{requestFields}'
        ], [
            $this->moduleName, $this->camelName, $this->getReqStubFields()
        ], $content);

        $path = "Modules/{$this->moduleName}/Http/Requests/{$this->camelName}Request.php";

        Storage::disk('root')->put($path, $content);
    }

    /**
     * 请求类字段
     * @return string
     */
    protected function getReqStubFields(): string
    {
        $fields = "";

        foreach ($this->fields as $field) {

            $fields .= "\t\t\t'{$field['name']}' => [],\n";
        }

        return $fields;
    }

    /**
     * 功能首页模板
     */
    protected function indexBladeStub()
    {
        $content = file_get_contents(base_path('Expand/FastCURD/stubs/index-blade.stub'));

        $content = $this->javascriptStub($content);
        $lowerModuleName = strtolower($this->moduleName);

        $path = "resources/views/{$lowerModuleName}/admin/{$this->lowerName}/index.blade.php";

        Storage::disk('root')->put($path, $content);
    }

    /**
     * 功能添加数据模板
     */
    protected function createBladeStub()
    {
        $fileName = $this->lang ? 'create-blade-lang.stub' : 'create-blade.stub';
        $content = file_get_contents(base_path('Expand/FastCURD/stubs/' . $fileName));

        $content = str_replace('{formFields}', $this->formCreateFields(), $content);

        $content = str_replace('{formLangFields}', $this->formCreateFields($this->lang), $content);

        $lowerModuleName = strtolower($this->moduleName);
        $path = "resources/views/{$lowerModuleName}/admin/{$this->lowerName}/create.blade.php";

        Storage::disk('root')->put($path, $content);
    }


    /**
     * 功能编辑数据模板
     */
    protected function editBladeStub()
    {
        $fileName = $this->lang ? 'edit-blade-lang.stub' : 'edit-blade.stub';
        $content = file_get_contents(base_path('Expand/FastCURD/stubs/' . $fileName));

        $content = str_replace('{formFields}', $this->formEditFields(), $content);

        $content = str_replace('{formLangFields}', $this->formEditFields($this->lang), $content);

        $lowerModuleName = strtolower($this->moduleName);
        $path = "resources/views/{$lowerModuleName}/admin/{$this->lowerName}/edit.blade.php";

        Storage::disk('root')->put($path, $content);
    }

    /**
     * 创建表单字段
     * @param bool $lang
     * @return string
     */
    protected function formCreateFields(bool $lang = false): string
    {
        $fields = "";

        foreach ($this->fields as $field) {

            $name = $field['comment'] ?: $field['name'];

            $fields .= "\t\t" . '<div class="row mb-3">' . "\n";
            $fields .= "\t\t\t" . '<label class="col-sm-2 col-form-label text-end-cms">' . $name . '</label>' . "\n";
            $fields .= "\t\t\t" . '<div class="col-sm-10">' . "\n";

            $eleName = $lang ? 'lang[{{$abb}}][' . $field['name'] . ']' : $field['name'];

            if ($field['type'] instanceof TextType) {
                $fields .= "\t\t\t\t" . '<textarea name="' . $eleName . '" id="' . $eleName . '"  class="form-control" placeholder="请输入' . $name . '"></textarea>' . "\n";
            } else {
                $fields .= "\t\t\t\t" . '<input type="text" name="' . $eleName . '"  class="form-control" placeholder="请输入' . $name . '" value="">' . "\n";
            }

            $fields .= "\t\t\t\t" . '<tip>填写' . $name . '。</tip>' . "\n";
            $fields .= "\t\t\t" . '</div>' . "\n";
            $fields .= "\t\t" . '</div>' . "\n\n";
        }

        return $fields;
    }

    /**
     * 编辑表单字段
     * @param bool $lang
     * @return string
     */
    protected function formEditFields(bool $lang = false): string
    {
        $fields = "";

        foreach ($this->fields as $field) {

            $name = $field['comment'] ?: $field['name'];

            $fields .= "\t\t" . '<div class="row mb-3">' . "\n";
            $fields .= "\t\t\t" . '<label class="col-sm-2 col-form-label text-end-cms">' . $name . '</label>' . "\n";
            $fields .= "\t\t\t" . '<div class="col-sm-10">' . "\n";

            $eleName = $lang ? 'lang[{{$abb}}][' . $field['name'] . ']' : $field['name'];

            if ($field['type'] instanceof TextType) {
                $fields .= "\t\t\t\t" . '<textarea name="' . $eleName . '" id="' . $eleName . '"  class="form-control" placeholder="请输入' . $name . '">' . ($lang ? '{{$langPage[$abb]["' . $field['name'] . '"] ?? ""}}' : '{{$data->' . $field['name'] . '}}') . '</textarea>' . "\n";
            } else {
                $fields .= "\t\t\t\t" . '<input type="text" name="' . $eleName . '"  class="form-control" placeholder="请输入' . $name . '" value="' . ($lang ? '{{$langPage[$abb]["' . $field['name'] . '"] ?? ""}}' : '{{$data->' . $field['name'] . '}}') . '">' . "\n";
            }

            $fields .= "\t\t\t\t" . '<tip>填写' . $name . '。</tip>' . "\n";
            $fields .= "\t\t\t" . '</div>' . "\n";
            $fields .= "\t\t" . '</div>' . "\n\n";
        }

        if ($lang) {
            $fields .= "\t\t" . '<input type="hidden" name="lang[{{$abb}}][id]" value="{{$langPage[$abb]["id"] ?? ""}}">' . "\n";
        }

        return $fields;
    }


    /**
     * js 生成
     */
    protected function javascriptStub($content)
    {

        $moduleName = strtolower($this->moduleName);

        return str_replace(
            ['{fields}', '{module}', '{lower}'],
            [$this->jsFields(), $moduleName, $this->lowerName],
            $content
        );
    }

    /**
     * 编辑表单字段
     * @return string
     */
    protected function jsFields(): string
    {
        $fields = "";

        foreach ($this->fields as $field) {

            $name = $field['comment'] ?: $field['name'];

            $fields .= "\t\t\t\t\t{field: '{$field['name']}', minWidth: 80, title: '{$name}'},\n";
        }

        return $fields;
    }

    /**
     * 路由
     * @return void
     */
    protected function routeHandle()
    {
        $content = file_get_contents(base_path('Expand/FastCURD/stubs/route.stub'));

        $moduleName = strtolower($this->moduleName);

        $content = str_replace(
            ['{camel}', '{module}', '{lower}'],
            [$this->camelName, $moduleName, $this->lowerName],
            $content
        );

        $path = "Modules/{$this->moduleName}/Routes/web.php";
        $routeCon = file_get_contents(base_path($path));
        $routeCon = str_replace("/* -curd- */", $content . "\n\n\t\t/* -curd- */", $routeCon);

        Storage::disk('root')->put($path, $routeCon);
    }

}
