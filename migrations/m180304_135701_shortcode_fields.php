<?php

class m180304_135701_shortcode_fields extends CDbMigration
{
	public function up()
	{
		//ALTER TABLE `da_menu` ADD `has_embed_widgets` INT(2) UNSIGNED NULL DEFAULT '0'
		

	}

	public function down()
	{
		echo "m180304_135701_shortcode_fields does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}