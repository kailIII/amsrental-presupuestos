<?php

namespace App\Services;

class HtmlBuilder extends \Illuminate\Html\HtmlBuilder
{

    function menu($href, $icon, $label)
    {
        return '<a href="' . url($href) . '"><i class="fa fa-' . $icon . ' fa-fw"></i> ' . $label . '</a>';
    }

    function simpleTable($collection, $modelName, $botones = [], $table_id = "")
    {
        $model = new $modelName();
        $data['prettyFields'] = $model->getPublicFields();
        $data['collection'] = $collection;
        $data['botones'] = $botones;
        $data['table_id'] = $table_id;

        return \View::make('templates.bootstrap.simpleTable', $data);
    }

    function tableModel($collection, $modelName, $hasDelete = true, $hasEdit = true, $hasAdd = true)
    {
        $model = new $modelName();
        $data['prettyFields'] = $model->getPublicFields();
        $data['collection'] = $collection;
        $ruta = \Route::getCurrentRoute();
        $data['url'] = url($ruta->getPath());
        $data['hasEdit'] = $hasEdit;
        $data['hasDelete'] = $hasDelete;
        $data['hasAdd'] = $hasAdd;
        $data['queryString'] = \Input::all();
        $data['params'] = "";
        foreach ($data['queryString'] as $key => $value) {
            $data['params'] .= "$key=$value&";
        }
        if ($hasAdd) {
            $data['urlAdd'] = $data['url'] . '/modificar?' . $data['params'];
            $data['nombreAdd'] = $model->getPrettyName();
        }

        return \View::make('templates.bootstrap.table', $data)->render();
    }

    function imageLink($hrefLink, $toltip, $urlImage)
    {
        return "<a href='" . url($hrefLink) . "'>"
        . "<img src='" . url($urlImage) . "' title='$toltip'></a>";
    }

    function jqplugin($name, $jsincludes = [])
    {
        $css = $js = "";
        if (file_exists(public_path('css/' . $name . '.min.css'))) {
            $css = \HTML::style('css/' . $name . '.min.css');
        }
        if (file_exists(public_path('js/jqplugins/' . $name . '.min.js'))) {
            $js = \HTML::script('js/jqplugins/' . $name . '.min.js');
        }
        foreach ($jsincludes as $jsinclude) {
            $js .= \HTML::script($jsinclude);
        }

        return $css . $js;
    }

    function bootstrap()
    {
        return \HTML::style('css/bootstrap.css') . \HTML::script('js/jquery.min.js') . \HTML::script('js/bootstrap.min.js');
    }

    function opcionMenu($link, $nombre, $icono, $header = false)
    {
        if ($header) {
            return "<a href='#'><i class='glyphicon glyphicon-$icono'></i><span> $nombre</span></a>";
        } else {
            return "<a class='ajax-link' href='" . url($link) . "'><i class='glyphicon glyphicon-$icono'></i><span> $nombre</span></a>";
        }
    }

    function btnAgregar($url, $nombre)
    {
        $data['url'] = $url;
        $data['nombre'] = $nombre;

        return View::make('templates.bootstrap.btnagregar', $data);
    }

}
