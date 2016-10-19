<?php

use \CaT\InstILIAS\Config\General;
use \CaT\InstILIAS\YamlParser;

class GeneralConfigTest extends PHPUnit_Framework_TestCase {
	public function setUp() {
		$this->parser = new YamlParser();
		$this->yaml_string = "---
client:
    data_dir : /data_dir
    name : Ilias5
    password_encoder : bcrypt 
database:
    host: 127.0.0.1
    database: ilias
    user: user
    password: passwd
    engine: innodb
    encoding: utf8_general_ci 
language:
    default_lang: de
    to_install_langs:
        - en
        - de
server:
    http_path: http://localhost/
    absolute_path: /yourpath
    timezone: Europe/Berlin
setup:
    master_password: passwd
tools:
    convert: /convert
    zip: /zip
    unzip: /unzip
    java: /java
log:
    path: /path
    file_name: ilias.log
git_branch:
    git_url: https://github.com/ILIAS-eLearning/ILIAS.git
    git_branch_name: release_5-1
category:
    categories:
        0:
            title: Eins
        1:
            title: Zwei
            children:
                10:
                    title: ZweiEins
                    children: []
                11:
                    title: ZweiZwei
                    children: []
        2:
            title: Drei
            children: []
orgunit:
    orgunits:
        0:
            title: &ORGU1 OrgEins
        1:
            title: OrgZwei
            children:
                10:
                    title: OrgZweiEins
                    children: []
                11:
                    title: OrgZweiZwei
                    children: []
        2:
            title: OrgDrei
            children: []
role:
    roles:
        0:
            title: Titel1
            description: Der darf alles sehen sonst nicht.
        1:
            title: Titel2
            description: Gruppe für alle
        2:
            title: Titel3
            description: Neue Menschen
ldap:
    name: ldap
    server: ldap://127.0.0.1:389
    basedn: cn=user,dc=dcdom,dc=local
    con_type: 1
    con_user_dn: cn=ldap,cn=user,dc=dcdom,dc=local
    con_user_pw: abcd
    sync_on_login: 1
    sync_per_cron: 0
    attr_name_user: sAMAccountName
    protocol_version: 3
    user_search_scope: 0
    register_role_name: User
plugin:
    plugins:
        0:
            name: Pluginname
            git:
                git_url: Bernd
                git_branch_name: master
https_auto_detect:
    enabled: 0
    header_name:
    header_value:
orgunit_type:
    orgunit_types:
        0:
            default_language: &ORGU1_TYPE_DEFAULT_LANGUAGE de
            type_language_settings:
                0:
                    language: de
                    title: &ORGU1_TYPE OrgunitTypeTest
                    description: Ich bin ein Test
orgunit_type_assignment:
    orgunit_type_assignments:
        0:
            orgunit_title: *ORGU1
            orgunit_type_default_language: *ORGU1_TYPE_DEFAULT_LANGUAGE
            orgunit_type_title: *ORGU1_TYPE
user:
    users:
        0:
           login: auto_test
           firstname: auto
           lastname: test
           gender: w
           email: stefan.hecken@concepts-and-training.de
           role: Administrator
password_settings:
    change_on_first_login: 1
    use_special_chars: 1
    numbers_and_chars: 1
    min_length: 8
    max_length: 0
    num_upper_chars: 1
    num_lower_chars: 1
    expire_in_days: 0
    forgot_password_aktive: 1
    max_num_login_attempts: 10
editor:
    enable_tinymce: 1
    repo_page_editor:
        enable: 1
        heavy_marked: 1
        marked: 1
        importand: 1
        superscript: 1
        subscript: 1
        comment: 1
        quote: 1
        accent: 1
        code: 1
        latex: 1
        footnote: 1
        external_link: 1
java_server:
    host: Test
    port: 8889
    index_path: /data_dir
    log_file: /path/log.file
    log_level: WARN
    num_threads: 1
    max_file_size: 500
    ini_path: /path
certificate:
    enable: 1
soap:
    enable: 1
    wdsl_path: http://files.php
    timeout: 10";
	}

	public function test_not_enough_params() {
		try {
			$config = new General();
			$this->assertFalse("Should have raised.");
		}
		catch (\InvalidArgumentException $e) {}
	}

	public function test_createIliasConfig() {
		$config = $this->parser->read_config($this->yaml_string, "\\CaT\\InstILIAS\\Config\\General");
		$this->assertInstanceOf("\\CaT\\InstILIAS\\Config\\General", $config);
		$this->assertInstanceOf("\\CaT\\InstILIAS\\Config\\Client", $config->client());
		$this->assertInstanceOf("\\CaT\\InstILIAS\\Config\\DB", $config->database());
		$this->assertInstanceOf("\\CaT\\InstILIAS\\Config\\Language", $config->language());
		$this->assertInstanceOf("\\CaT\\InstILIAS\\Config\\Server", $config->server());
		$this->assertInstanceOf("\\CaT\\InstILIAS\\Config\\Setup", $config->setup());
		$this->assertInstanceOf("\\CaT\\InstILIAS\\Config\\Tools", $config->tools());
		$this->assertInstanceOf("\\CaT\\InstILIAS\\Config\\Log", $config->log());
		$this->assertInstanceOf("\\CaT\\InstILIAS\\Config\\GitBranch", $config->git_branch());
		$this->assertInstanceOf("\\CaT\\InstILIAS\\Config\\Categories", $config->category());
		$this->assertInstanceOf("\\CaT\\InstILIAS\\Config\\OrgUnits", $config->orgunit());
		$this->assertInstanceOf("\\CaT\\InstILIAS\\Config\\Roles", $config->role());
		$this->assertInstanceOf("\\CaT\\InstILIAS\\Config\\LDAP", $config->ldap());
		$this->assertInstanceOf("\\CaT\\InstILIAS\\Config\\Plugins", $config->plugin());
		$this->assertInstanceOf("\\CaT\\InstILIAS\\Config\\HTTPSAutoDetect", $config->httpsAutoDetect());
		$this->assertInstanceOf("\\CaT\\InstILIAS\\Config\\OrgunitTypes", $config->orgunitType());
		$this->assertInstanceOf("\\CaT\\InstILIAS\\Config\\OrgunitTypeAssignments", $config->orgunitTypeAssignment());
		$this->assertInstanceOf("\\CaT\\InstILIAS\\Config\\Users", $config->user());
		$this->assertInstanceOf("\\CaT\\InstILIAS\\Config\\PasswordSettings", $config->passwordSettings());
		$this->assertInstanceOf("\\CaT\\InstILIAS\\Config\\Editor", $config->editor());
		$this->assertInstanceOf("\\CaT\\InstILIAS\\Config\\JavaServer", $config->javaServer());
		$this->assertInstanceOf("\\CaT\\InstILIAS\\Config\\Certificate", $config->certificate());
	}
}