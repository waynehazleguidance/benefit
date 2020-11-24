# Tests Skeleton

Welcome to the Guidance **Tests Skeleton** project. 

This project is the basis (skeleton) for any tests automation project in Guidance, which means
that any tests automation project will be a fork of this project. 

The project is based on the popular WebDriver framework for PHP - [Codeception](https://codeception.com).

***Note:*** 
- Before you start working with project, we recommend you to read Codeception [documentation](https://codeception.com/docs).
- The project depends on another Guidance project [Tests Base](https://github.com/guidance/tests_base), 
which, like this project, is in a private repository, and you also need access to it to successfully install dependencies.

## Getting started

### Installation

Create your new tests app folder, for example we named it `example_test_app`.

Switch to the app folder

    cd example_test_app

Clone the repository to your app folder

    git clone https://github.com/guidance/tests_skeleton.git .

Install all the dependencies using composer

    composer install
    
### Configuration

Before launch tests app you need to configure WebDriver with correct `host` and `port` in right configuration file depends on entry point you want to use.

### Entry points

There are three entry points available for launching - `bs`, `dev`, `prod`.
All of this entrances have own configuration file.

- `bin/bs` - launch tests with remote Webdriver on BrowserStack. Config file - `config/codecept/browserstack.yml`.

***Note:*** You will also have test run result with raw Webdriver log and video of testing process in authorized BrowserStack account.

- `bin/dev` - used in development environment for tests launch. Config file - `config/codecept/development.yml`.

- `bin/stage` - used in staging environment for tests launch. Config file - `config/codecept/staging.yml`.

- `bin/prod` - used in production environment for tests launch. Config file - `config/codecept/production.yml`.

***Note:*** If you want to use any other Codeception command except of `run`, you should use their entry point - `vendor/codeception/codeception/codecept` or `vendor/bin/codecept`.

### Arguments

|    name   |    description    |  required |
|-----------|-------------------|-----------|
| suite     | suite to be tested|    yes    | 
| test      | test to be run 	|    no     |  

***Note:*** 
- all suites present in configuration files
- if `test` argument is not passed, then all tests will launch

**Example run command:**

>`bin/bs run Test/Project DemoCest.php`

### Options

We accept all Codeception options you can take a look on `run` command's options [here](https://codeception.com/docs/reference/Commands).
There is also default options for each entry point you can configure in file - `config/codecept/default_options.php`

**Website custom option:**

We also add our custom option `--website` which allow you to have several configuration files for each website inside one project.

**Example run command with options:**

>`bin/bs run Test/Project DemoCest.php --silent --no-exit --website US`
___

## Code overview

### Dependencies

[Tests Base](https://github.com/guidance/tests_base) - this is the base tests functionality project.

### Folders

- `bin` - Contains all the entry points
- `config` - Contains all the application configuration files
- `data` - Contains the content for the Data Provider pattern. It includes `general` and `individual` content, depending on usage area
- `dev/misc` - Contains all the miscellaneous files, usually not directly related to project or temporary
- `dev/docs` - Contains the all kinds of documentation or information about the functionality associated with the project
- `src/Actor/Extension` - Contains the all [Helpers](https://codeception.com/docs/06-ModulesAndHelpers), which enlarge Codeception Actor
- `src/Module` - Contains all the application [Modules](https://github.com/guidance/tests_base/#module)
- `src/Test` - Contains all the application tests
- `vars` - Contains the all files to which the application writes data during its work
- `vendor` - Contains all the Composer dependencies# benefit
