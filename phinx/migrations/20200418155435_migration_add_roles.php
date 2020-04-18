<?php

use Phinx\Migration\AbstractMigration;

class MigrationAddRoles extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table('role', ['id' => false, 'primary_key' => ['role_id']])
            ->addColumn('role_id',    'integer',  ['identity' => true])
            ->addColumn('role_name',  'string',   ['limit' => 255, 'null' => false])
            ->addColumn('name',       'string',   ['limit' => 255, 'null' => false])
            ->addColumn('purpose',    'text',     ['null' => false])
            ->addColumn('created_at', 'datetime', ['null' => false])
            ->addColumn('updated_at', 'datetime', ['null' => false])
            ->create();

        $this->table('role')
            ->insert([
                [
                    'role_name' => 'best-of-voting.admin',
                    'name' => 'Best-of Voting Admin',
                    'purpose' => 'Grants full access to the Best-of Voting backend',
                    'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
                    'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
                ],
            ])
            ->saveData();

        $this->table('role_user', ['id' => false, 'primary_key' => ['role_user_id']])
            ->addColumn('role_user_id', 'integer',  ['identity' => true])
            ->addColumn('role_id',      'integer',  ['null' => false])
            ->addColumn('user_id',      'integer',  ['null' => false])
            ->addColumn('created_at',   'datetime', ['null' => false])
            ->addColumn('updated_at',   'datetime', ['null' => false])
            ->create();
    }
}
