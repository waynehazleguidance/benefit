
# Tests Base

Welcome to the Guidance **Tests Base** project. 
This is the base tests functionality project. 
The project is not self-sufficient for its launch (use fork of [this](https://github.com/guidance/tests_skeleton) project for launching).
**Tests Base** includes implementation of such Patterns for testing as *Page Object* (UIMap Object), *Data Registry*, *Data Provider*. 

## Code overview

### Entities

Project operates with such accustomed Codeception entities like `Actor` and `Test`,
but also bring in a newly entity [`Module`](#module).

#### <a name="module">Module</a>

***Path:*** `src/Module`
 
The main idea of the `Modules` is to pick out the functionality for its further reuse.
This entity is NOT the same as Codeception [Modules or Helpers](https://codeception.com/docs/06-ModulesAndHelpers).
Our `Modules` point to a more extensive concept of use. They can do very different jobs. 
For example, one Module can connect and make changes to the database, while another Module logs in to the admin panel using WebDriver.
We've also implemented *Data Provider* pattern as Module and put it here in **Tests Base** project.

***Note:*** It's important to put your module to the correct project layer depending on the context of its use.

### Dependencies

- [codeception](https://github.com/fzaninotto/Faker) - testing framework
- [php-di](https://github.com/fzaninotto/Faker) - library to implement DI pattern in project
- [memio](https://github.com/memio/memio) - class generator library for generate Page Objects (UIMap Objects)
- [faker](https://github.com/fzaninotto/Faker) - library to implement Data Registry pattern in project
