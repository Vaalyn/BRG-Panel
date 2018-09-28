<?php

use Phinx\Migration\AbstractMigration;

class MigrationAddAuthorizationTokenTable extends AbstractMigration
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
		$this->table('auth_token')
			->rename('authentication_token')
			->renameColumn('auth_token_id', 'authentication_token_id')
			->update();

		$this->table('authorization_token', ['id' => false, 'primary_key' => ['authorization_token_id']])
			->addColumn('authorization_token_id', 'integer',  ['identity' => true])
			->addColumn('user_id',                'integer',  ['null' => false])
			->addColumn('token',                  'string',   ['limit' => 255, 'null' => false])
			->addColumn('purpose',                'text',     ['null' => false])
			->addColumn('created_at',             'datetime', ['null' => false])
			->addColumn('updated_at',             'datetime', ['null' => false])
			->create();

		$this->table('authorized_route', ['id' => false, 'primary_key' => ['authorized_route_id']])
			->addColumn('authorized_route_id',    'integer',  ['identity' => true])
			->addColumn('authorization_token_id', 'integer',  ['null' => false])
			->addColumn('route_name',             'text',     ['null' => false])
			->addColumn('created_at',             'datetime', ['null' => false])
			->addColumn('updated_at',             'datetime', ['null' => false])
			->create();
    }
}
