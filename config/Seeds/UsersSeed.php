<?php
use Migrations\AbstractSeed;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
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
        $data = [
            [
                'id' => '1',
                'email' => 'cakephp@example.com',
                'password' => 'sekret',
                'created' => '2017-12-07 23:03:34',
                'modified' => '2017-12-07 23:03:34',
            ],
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
