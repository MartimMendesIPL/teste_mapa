<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cultural_sites}}`.
 */
class m251016_134329_create_cultural_sites_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%cultural_sites}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'type' => $this->string(100)->notNull()->comment('museum, monument, cultural_site'),
            'latitude' => $this->decimal(10, 8)->notNull(),
            'longitude' => $this->decimal(11, 8)->notNull(),
            'address' => $this->string(500),
            'phone' => $this->string(50),
            'website' => $this->string(500),
            'image_url' => $this->string(500),
            'opening_hours' => $this->string(500),
            'city' => $this->string(100)->notNull(),
            'region' => $this->string(100)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // Create indexes for better query performance
        $this->createIndex(
            'idx-cultural_sites-city',
            '{{%cultural_sites}}',
            'city'
        );

        $this->createIndex(
            'idx-cultural_sites-region',
            '{{%cultural_sites}}',
            'region'
        );

        $this->createIndex(
            'idx-cultural_sites-type',
            '{{%cultural_sites}}',
            'type'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cultural_sites}}');
    }
}
