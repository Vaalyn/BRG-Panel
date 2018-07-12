<?php

use Phinx\Migration\AbstractMigration;

class Migration extends AbstractMigration {
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
    public function change() {
		$this->table('auth_token', ['id' => false, 'primary_key' => ['auth_token_id']])
			->addColumn('auth_token_id', 'uuid',     [])
			->addColumn('user_id',       'integer',  ['null' => false])
			->addColumn('token',         'string',   ['limit' => 255, 'null' => false])
			->addColumn('browser',       'text',     ['null' => false])
			->addColumn('created_at',    'datetime', ['null' => false])
			->addColumn('updated_at',    'datetime', ['null' => false])
			->addColumn('deleted_at',    'datetime', ['default' => null, 'null' => true])
			->create();

		$this->table('coin_event', ['id' => false, 'primary_key' => ['id']])
			->addColumn('id',                'integer',  ['identity' => true])
			->addColumn('event',             'string',   ['limit' => 255, 'null' => false])
			->addColumn('coins',             'integer',  ['null' => false])
			->addColumn('created_at',        'datetime', ['null' => false])
			->addColumn('id_community_user', 'integer',  ['null' => false])
			->create();

		$this->table('community_user', ['id' => false, 'primary_key' => ['id']])
			->addColumn('id',               'integer',    ['identity' => true])
			->addColumn('discord_username', 'string',     ['limit' => 255, 'null' => false])
			->addColumn('discord_user_id',  'string',     ['limit' => 255, 'null' => false])
			->addColumn('coins',            'biginteger', ['null' => false])
			->create();

		$this->table('current_event', ['id' => false, 'primary_key' => ['id']])
			->addColumn('id',    'integer', ['identity' => true])
			->addColumn('title', 'text',    ['null' => false])
			->create();

		$this->table('current_event')
			->insert([['title' => 'DJ-Pony Lucy']])
			->saveData();

		$this->table('donation', ['id' => false, 'primary_key' => ['id']])
			->addColumn('id',       'integer', ['identity' => true])
			->addColumn('amount',   'decimal', ['precision' => 10, 'scale' => 2, 'null' => false])
			->addColumn('id_donor', 'integer', ['null' => false])
			->addColumn('deleted',  'boolean', ['default' => false, 'null' => false])
			->create();

		$this->table('donor', ['id' => false, 'primary_key' => ['id']])
			->addColumn('id',   'integer', ['identity' => true])
			->addColumn('name', 'string',  ['limit' => 255, 'null' => false])
			->create();

		$this->table('message', ['id' => false, 'primary_key' => ['id_message']])
			->addColumn('id_message',   'integer',  ['identity' => true])
			->addColumn('message_text', 'text',     ['limit' => 'TEXT_MEDIUM', 'null' => false])
			->addColumn('nickname',     'string',   ['limit' => 255, 'null' => false])
			->addColumn('message_time', 'datetime', ['null' => false])
			->addColumn('active',       'boolean',  ['default' => false, 'null' => false])
			->create();

		$this->table('request', ['id' => false, 'primary_key' => ['id_request']])
			->addColumn('id_request',     'integer',  ['identity' => true])
			->addColumn('title',          'string',   ['limit' => 255, 'null' => false])
			->addColumn('artist',         'string',   ['limit' => 255, 'null' => false])
			->addColumn('url',            'string',   ['limit' => 255, 'null' => false])
			->addColumn('nickname',       'string',   ['limit' => 255, 'null' => false])
			->addColumn('message',        'text',     ['null' => false])
			->addColumn('ip_address',     'string',   ['limit' => 255, 'null' => false])
			->addColumn('requested_time', 'datetime', ['null' => false])
			->addColumn('skipped',        'boolean',  ['default' => false, 'null' => false])
			->addColumn('active',         'boolean',  ['default' => false, 'null' => false])
			->create();

		$this->table('setting', ['id' => false, 'primary_key' => ['id']])
			->addColumn('id',    'integer', ['identity' => true])
			->addColumn('key',   'string',  ['limit' => 255, 'null' => false])
			->addColumn('value', 'string',  ['limit' => 255, 'null' => false])
			->create();

		$this->table('setting')
			->insert([
				[
					'key' => 'currently_needed_donation_amount',
					'value' => '0'
				]
			])
			->saveData();

		$this->table('status', ['id' => false, 'primary_key' => ['id_status']])
			->addColumn('id_status',     'integer', ['identity' => true])
			->addColumn('active',        'boolean', ['default' => false, 'null' => false])
			->addColumn('request_limit', 'integer', ['null' => false])
			->addColumn('description',   'string',  ['limit' => 255, 'null' => false])
			->create();

		$this->table('status')
			->insert([
				[
					'active' => false,
					'request_limit' => 1,
					'description' => 'System Status'
				],
				[
					'active' => false,
					'request_limit' => 0,
					'description' => 'Message System Aktiv'
				],
				[
					'active' => true,
					'request_limit' => 1,
					'description' => 'AutoDj Request'
				]
			])
			->saveData();

		$this->table('stream', ['id' => false, 'primary_key' => ['id']])
			->addColumn('id',         'integer', ['identity' => true])
			->addColumn('mountpoint', 'string',  ['limit' => 255, 'null' => false])
			->addColumn('listener',   'integer', ['null' => false])
			->addColumn('artist',     'string',  ['limit' => 255, 'null' => false])
			->addColumn('title',      'string',  ['limit' => 255, 'null' => false])
			->addColumn('status',     'string',  ['limit' => 255, 'null' => false])
			->create();

		$this->table('tracks', ['id' => false, 'primary_key' => ['id']])
			->addColumn('id',           'integer', ['identity' => true])
			->addColumn('pathname',     'text',    ['limit' => 'TEXT_MEDIUM', 'null' => false])
			->addColumn('title',        'string',  ['limit' => 255, 'null' => false])
			->addColumn('length',       'integer', ['null' => false])
			->addColumn('url',          'text',    ['null' => false])
			->addColumn('artistid',     'integer', ['null' => false])
			->addColumn('autodj',       'boolean', ['default' => false, 'null' => false])
			->addColumn('ignore_votes', 'boolean', ['default' => false, 'null' => false])
			->create();

		$this->table('track_artists', ['id' => false, 'primary_key' => ['id']])
			->addColumn('id',   'integer', ['identity' => true])
			->addColumn('name', 'string',  ['limit' => 255, 'null' => false])
			->create();

		$this->table('track_history', ['id' => false, 'primary_key' => ['id']])
			->addColumn('id',          'integer', ['identity' => true])
			->addColumn('date_played', 'date',    ['null' => false])
			->addColumn('time_played', 'time',    ['null' => false])
			->addColumn('artist',      'string',  ['limit' => 255, 'null' => false])
			->addColumn('title',       'string',  ['limit' => 255, 'null' => false])
			->create();

		$this->table('track_votes', ['id' => false, 'primary_key' => ['id']])
			->addColumn('id',         'integer',  ['identity' => true])
			->addColumn('trackid',    'integer',  ['null' => false])
			->addColumn('upvote',     'boolean',  ['default' => false, 'null' => false])
			->addColumn('downvote',   'boolean',  ['default' => false, 'null' => false])
			->addColumn('ip_address', 'string',   ['limit' => 255, 'null' => false])
			->addColumn('voter_id',   'string',   ['limit' => 255, 'null' => false])
			->addColumn('vote_time',  'datetime', ['null' => false])
			->addIndex(['trackid', 'voter_id'], ['unique' => true])
			->create();

		$this->table('user', ['id' => false, 'primary_key' => ['id_user']])
			->addColumn('id_user',      'integer',  ['identity' => true])
			->addColumn('user_id',      'integer',  ['null' => false])
			->addColumn('name',         'string',   ['limit' => 255, 'null' => false])
			->addColumn('username',     'string',   ['limit' => 255, 'null' => false])
			->addColumn('password',     'string',   ['limit' => 255, 'null' => false])
			->addColumn('password_new', 'string',   ['limit' => 255, 'null' => false])
			->addColumn('salt',         'string',   ['limit' => 255, 'null' => false])
			->addColumn('admin',        'boolean',  ['default' => false, 'null' => false])
			->addColumn('usergroup',    'string',   ['limit' => 255, 'null' => false])
			->addColumn('email',        'string',   ['limit' => 255, 'null' => false])
			->addColumn('is_admin',     'boolean',  ['default' => false, 'null' => false])
			->addColumn('created_at',   'datetime', ['null' => false])
			->addColumn('updated_at',   'datetime', ['null' => false])
			->addColumn('deleted_at',   'datetime', ['default' => null, 'null' => true])
			->create();
    }
}
