<?php

/**
 * Class Home
 * Retrieves information and build home screen
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Home extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        // create a client instance
        $client = new Solarium\Client($this->config);

        // get a select query instance
        $query = $client->createSelect();

        // set start and rows param (comparable to SQL limit) using fluent interface
        $query->setRows(4);

        $query->addSort('indexingDate_s', $query::SORT_DESC);

        // this executes the query and returns the result
        $resultset = $client->select($query);
        
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/index.php';
        require APP . 'view/_templates/footer.php';
    }
}
