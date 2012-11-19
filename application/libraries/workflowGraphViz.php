<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of workflowGraphViz
 *
 * @author farid
 */
class WorkflowGraphViz
{
    var $binPath;
    var $dotCommand = 'dot';

    function WorkflowGraphViz(){
        $this->binPath = dirname(__FILE__) ."/graphviz-2.20.2/bin/";
    }
    
    function image($data, $format = 'svg', $command = null)
    {
        $file = $this->saveParsedGraph($data);
        if (!$file)
        {
            return $file;
        }

        $outputfile = $file . '.' . $format;

        $rendered = $this->renderDotFile($file, $outputfile, $format, $command);
        if ($rendered !== true)
        {
            return $rendered;
        }

        $sendContentLengthHeader = true;

        switch (strtolower($format))
        {
            case 'gif':
            case 'png':
            case 'bmp':
            case 'jpeg':
            case 'tiff':
                header('Content-Type: image/' . $format);
                break;

            case 'tif':
                header('Content-Type: image/tiff');
                break;

            case 'jpg':
                header('Content-Type: image/jpeg');
                break;

            case 'ico':
                header('Content-Type: image/x-icon');
                break;

            case 'wbmp':
                header('Content-Type: image/vnd.wap.wbmp');
                break;

            case 'pdf':
                header('Content-Type: application/pdf');
                break;

            case 'mif':
                header('Content-Type: application/vnd.mif');
                break;

            case 'vrml':
                header('Content-Type: application/x-vrml');
                break;

            case 'svg':
                header('Content-Type: image/svg+xml');
                break;

            case 'plain':
            case 'plain-ext':
                header('Content-Type: text/plain');
                break;

            default:
                header('Content-Type: application/octet-stream');
                $sendContentLengthHeader = false;
        }

        if ($sendContentLengthHeader)
        {
            header('Content-Length: ' . filesize($outputfile));
        }

        $return = true;
        if (readfile($outputfile) === false)
        {
            $return = false;
        }
        @unlink($outputfile);

        return $return;
    }

    function saveParsedGraph($data = array(), $file = 'graph_')
    {
        $parsedGraph = $this->parse($data);

        if (!empty($parsedGraph))
        {
            if (file_put_contents($file, $parsedGraph))
                return $file;
        }

        return false;
    }

    function renderDotFile($dotfile, $outputfile, $format = 'svg', $command = null)
    {
        
        if (!file_exists($dotfile))
        {
            return false;
        }

        $oldmtime = file_exists($outputfile) ? filemtime($outputfile) : 0;

        switch ($command)
        {
            case 'dot':
            case 'neato':
                break;
            default:
                $command = 'dot';
        }
        $command_orig = $command;

        $command = $this->binPath . $this->dotCommand;

        $command .= ' -T' . escapeshellarg($format)
                . ' -o' . escapeshellarg($outputfile)
                . ' ' . escapeshellarg($dotfile)
                . ' 2>&1';
        $r = exec($command, $msg, $return_val);
        
        clearstatcache();
        if (file_exists($outputfile) && filemtime($outputfile) > $oldmtime && $return_val == 0)
        {
            return true;
        }
        
        return false;
    }

    public function parse($data = array())
    {
        $separator = ' -> ';
        $indent = '    ';
        
        $parsedGraph  = 'digraph G { ' . PHP_EOL;

        foreach ($data['config'] as $key => $value) {
            //$parsedGraph .= $indent.$key.$indent.json_encode($value).";" . PHP_EOL;

            $search= array('{','"',':','}');
            $replace= array('[','','=',']');
            $value = str_replace($search, $replace, json_encode($value));
            
            $parsedGraph .=  $indent.$key.$indent.$value.";" . PHP_EOL;
            
        }
        
        foreach ($data['node'] as $key => $value) {
            //labelURL
            $opt = ($value['tipe'] == 'system' ? '[ label="' .$value['label']. '",style=filled ]' : '[ label="' .$value['label']. '",shape=doublecircle,style=filled ]');
            $parsedGraph .= $indent.'"'.trim($value['from']).'"'.$separator.'"'.trim($value['to']).'" '.$opt.';'. PHP_EOL;
        }
        
        $parsedGraph  .= '}' . PHP_EOL;

        return $parsedGraph;
    }

}
?>
