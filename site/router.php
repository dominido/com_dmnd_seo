<?php

function Dmnd_seoBuildRoute( &$query )
{
        //print_r($query);

       $segments = array();

       if(isset($query['view']))
       {
                if ($query['view'] == 'video' || $query['view'] == 'audio' || $query['view'] == 'gallery')
                    $segments[] = $query['view'];

                unset( $query['view'] );
       }

       if(isset($query['id']))
       {
                $segments[] = $query['id'];
                unset( $query['id'] );
       }

       if(isset($query['id2']))
       {
                $segments[] = $query['id2'];
                unset( $query['id2'] );
       }

       //print_r($segments);

       return $segments;
}

function Dmnd_seoParseRoute( $segments )
{
    $vars = array();

    $app = JFactory::getApplication();
    $menu = $app->getMenu();
    $item = $menu->getActive();

    $count = count($segments);

    if (isset($item->query['view'])) {
        switch ($item->query['view']) {
            case 'videos':
                if ($count == 1) {
                    $vars['view'] = 'video';
                    $vars['alias'] = (string) $segments[0];
                    $vars['alias'] = str_replace(":", "-", $vars['alias']);
                }
                break;
        }
    }

    return $vars;
}

?>