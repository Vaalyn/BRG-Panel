<?php

use Phinx\Migration\AbstractMigration;

class MigrationMessageTableChanges extends AbstractMigration
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
		$this->table('message')
			->addColumn('updated_at', 'datetime', ['null' => false])
			->addColumn('deleted_at', 'datetime', ['default' => null, 'null' => true])
			->changeColumn('message_text', 'text', ['after' => 'nickname', 'limit' => 'TEXT_MEDIUM', 'null' => false])
			->renameColumn('id_message', 'message_id')
			->renameColumn('message_text', 'message')
			->renameColumn('message_time', 'created_at')
			->update();

		$this->execute('UPDATE message SET updated_at = created_at');
		$this->execute('UPDATE message SET deleted_at = NOW() WHERE active = 0');

		$this->table('message')
			->removeColumn('active')
			->update();
    }
}
