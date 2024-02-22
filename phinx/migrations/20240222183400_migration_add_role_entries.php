<?php

use Phinx\Migration\AbstractMigration;

class MigrationAddRoleEntries extends AbstractMigration
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
        $this->table('role')
            ->insert([
                [
                    'role_name' => 'history.access',
                    'name' => 'History Access',
                    'purpose' => 'Grants access to the history page',
                    'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
                    'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
                ],
                [
                    'role_name' => 'statistic.access',
                    'name' => 'Statistic Access',
                    'purpose' => 'Grants access to the statistic pages',
                    'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
                    'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
                ],
            ])
            ->saveData();
    }
}
