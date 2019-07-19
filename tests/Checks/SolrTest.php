<?php
namespace Tests\Checks;

use Health\Checks\Servers\Solr;

class SolrTest extends CheckTestCase
{
    public function testCheckSolr()
    {
        $this->assertCheck($this->runCheck(Solr::class), 'DOWN');
    }
}