<?php 

define('ENTITY_ARTIST', 'aritst');
define('ENTITY_ALBUMS', 'albums');
    
    function APIDescription() {
        return addHATEOAS();
    }

    //create url path that changes based on current directory. Can be used on localhost via 443 port XAMPP or https provider
    function urlPath() {
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
        return $protocol . $_SERVER['HTTP_HOST'] . '/' . basename(__DIR__) . '/';     
    }

    //hypermedia as the engine application state
    //part of RESTful design
    //provides connection through content with connections for more content.
    function addHATEOAS($information = null, $entity = null) {
        //value with current directory
        $curDir = urlPath();

        if (!is_null($entity)) {
            $apiInfo[$entity] = $information;
        }
        $apiInfo['_links'] = array(
            array(
                'rel' => ($entity == ENTITY_ARTIST ? 'self' : ENTITY_ARTIST),
                'href' => $curDir . ENTITY_ARTIST . '{?title=}',
                'type' => 'GET'
            ),
            array(
                'rel' => ($entity == ENTITY_ARTIST ? 'self' : ENTITY_ARTIST),
                'href' => $curDir . ENTITY_ARTIST . '/{id}',
                'type' => 'GET'
            ),
            array(
                'rel' => ($entity == ENTITY_ARTIST ? 'self' : ENTITY_ARTIST),
                'href' => $curDir . ENTITY_ARTIST,
                'type' => 'POST'
            ),
            array(
                'rel' => ($entity == ENTITY_ARTIST ? 'self' : ENTITY_ARTIST),
                'href' => $curDir . ENTITY_ARTIST . '/{id}',
                'type' => 'PUT'
            ),
            array(
                'rel' => ($entity == ENTITY_ARTIST ? 'self' : ENTITY_ARTIST),
                'href' => $curDir . ENTITY_ARTIST . '/{id}',
                'type' => 'DELETE'
            ),
            array(
                'rel' => ($entity == ENTITY_ALBUMS ? 'self' : ENTITY_ALBUMS),
                'href' => $curDir . ENTITY_ALBUMS . '{?name=}',
                'type' => 'GET'
            ),
            array(
                'rel' => ($entity == ENTITY_ALBUMS ? 'self' : ENTITY_ALBUMS),
                'href' => $curDir . ENTITY_ALBUMS,
                'type' => 'POST'
            ),
            array(
                'rel' => ($entity == ENTITY_ALBUMS ? 'self' : ENTITY_ALBUMS),
                'href' => $curDir . ENTITY_ALBUMS . '{id}',
                'type' => 'DELETE'
            )
        );        
        return json_encode($apiInfo);
    }

    /**
     * Returns a format error
     */
    function formatError() {
        $output['message'] = 'Incorrect format';
        return addHATEOAS($output, '_error');
    }



?>