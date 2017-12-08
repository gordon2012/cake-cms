<?php
use Migrations\AbstractSeed;

/**
 * Initial seed.
 */
class InitialSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $this->call('UsersSeed');
        $this->call('ArticlesSeed');
    }
}
