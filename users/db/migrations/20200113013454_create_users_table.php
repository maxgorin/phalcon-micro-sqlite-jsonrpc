<?php

use Phinx\Db\Adapter\SQLiteAdapter;
use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration {
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
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change() {

        $table = $this->table('users');

        $table->addColumn('login', SQLiteAdapter::PHINX_TYPE_STRING)
            ->addColumn('password', SQLiteAdapter::PHINX_TYPE_STRING)
            ->addColumn('created_at', SQLiteAdapter::PHINX_TYPE_DATETIME)
            ->addColumn('updated_at', SQLiteAdapter::PHINX_TYPE_DATETIME, ['null' => true]);

        $table->addIndex('login');

        $table->create();

        $table->insert([
            'login' => 'admin',
            'password' => (new Phalcon\Security())->hash('admin', 6),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $table->save();

    }
}
