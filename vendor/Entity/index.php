<?php

namespace App\Vendor;

class AppEntity {
	private $entityName;
	private $entityColumns;

	public function make() {
		$app_path = realpath('./app');
		$entityFile = fopen($app_path."/entities/".$this->entityName.".php", "w");

		$tbl_name = strtolower($this->entityName);

		// Open PHP
		$php_open = "<?php\n";
		fwrite($entityFile, $php_open);

		//Set comments
		$entity_comment = "\n/*\n\tBookyow\n\tApplication\n\n*/";
		fwrite($entityFile, $entity_comment);


		//Set namespace
		$entity_body = "\n\nnamespace App\Entity;\n\nclass $this->entityName {\n\tprivate \$tbl_name = '$tbl_name';\n\tprivate \$id;";

		foreach (explode(',', $this->entityColumns) as $column) {
			$entity_body .= "\n\tprivate \$$column;";
		}

		$entity_body .= "\n\n\tpublic function getID() {\n\t\treturn \$this->id;\n\t}";

		foreach (explode(',', $this->entityColumns) as $column) {
			$function_name_set = 'set'.ucfirst($column);
			$function_name_get = 'get'.ucfirst($column);
			$entity_body .= "\n\n\tpublic function $function_name_set(\$$column) {\n\t\t\$this->$column = \$$column;\n\t}\n\n\tpublic function $function_name_get() {\n\t\treturn \$this->$column;\n\t}";
		}

		$entity_body .= "\n}";
		fwrite($entityFile, $entity_body);

		fclose($entityFile);

		return "\033[33mYou made an Entity named ".$this->entityName;
	}

	public function setEntityName($entityName) {
		$this->entityName = $entityName;
	}

	public function setColumns($console_vars) {
		$this->entityColumns = $console_vars;
	}
}

use App\Vendor\AppEntity;
$entity = new AppEntity();

if ($console_command == 'make' AND $console_class = 'entity') {
	$entity->setEntityName($console_value);
	$entity->setColumns($console_vars);

	echo $entity->make();
}