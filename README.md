# Vault
A password manager for privacy and security conscious users.

Project supervisor: Dr Shaymaa Al-Juboori

## Project Vision
The product is for security-conscious users who are worried about the possibility of a breach in a password management system they do not control, such events like this have happened in the past such as LastPass’s breach in. The Vault product is a free and easy to use password manager/vault that can be self-hosted on a web server or ran on a local machine to store and view passwords. The system can be run on a webserver or a local machine offline to help mitigate against attacks, which have become more common against major password management companies.

The project will be developed in two parts, a JavaScript-based offline/syncable application and a PHP-JavaScript web-based application for users who prefer to use the cloud.

## Quick Links
* [UML Diagrams](https://github.com/lewmilburn/Vault/issues/1)
* [Kanban Board](https://github.com/users/lewmilburn/projects/3/views/3)
* [Gantt Chart](https://github.com/users/lewmilburn/projects/3/views/2)
* [Documentation](https://github.com/lewmilburn/Vault/wiki)
* [Demo Video](https://youtu.be/_bd3XUPydaE)

## Testing

The below badges will automatically update, you can also see all information about SonarCloud Testing and the results here: https://sonarcloud.io/summary/overall?id=lewmilburn_Vault

### Stats
[![Lines of Code](https://sonarcloud.io/api/project_badges/measure?project=lewmilburn_Vault&metric=ncloc)](https://sonarcloud.io/summary/new_code?id=lewmilburn_Vault)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=lewmilburn_Vault&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=lewmilburn_Vault)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=lewmilburn_Vault&metric=vulnerabilities)](https://sonarcloud.io/summary/new_code?id=lewmilburn_Vault)
[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=lewmilburn_Vault&metric=bugs)](https://sonarcloud.io/summary/new_code?id=lewmilburn_Vault)
[![Code Smells](https://sonarcloud.io/api/project_badges/measure?project=lewmilburn_Vault&metric=code_smells)](https://sonarcloud.io/summary/new_code?id=lewmilburn_Vault)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=lewmilburn_Vault&metric=sqale_index)](https://sonarcloud.io/summary/new_code?id=lewmilburn_Vault)
[![Duplicated Lines (%)](https://sonarcloud.io/api/project_badges/measure?project=lewmilburn_Vault&metric=duplicated_lines_density)](https://sonarcloud.io/summary/new_code?id=lewmilburn_Vault)
[![StyleCI Status](https://github.styleci.io/repos/706635533/shield)](https://github.styleci.io/repos/706635533)

### Ratings
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=lewmilburn_Vault&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=lewmilburn_Vault)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=lewmilburn_Vault&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=lewmilburn_Vault)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=lewmilburn_Vault&metric=reliability_rating)](https://sonarcloud.io/summary/new_code?id=lewmilburn_Vault)

### Unit Tests
You can run the ./test/test.php file to run unit tests. This folder should not be uploaded to a webserver running Vault.

## Theoretical Limits
### FILESYSTEM storage.
Filesystem storage has no real limit, you can store as many passwords as you'd like, it just may slow down the more you add.

### DATABASE storage.
Database storage can hold up to 16 Megabytes of data, which is estimated to be over 1,000 passwords.

## Software-specific Information
- [Web (Sync Server)](https://github.com/lewmilburn/Vault/blob/main/Web/README.md)
- [Client](https://github.com/lewmilburn/Vault/blob/main/Client/README.md)

# Legal
Released under the [Apache License](https://github.com/lewmilburn/Vault/blob/main/LICENSE). [Read the disclaimer before using](https://github.com/lewmilburn/Vault/blob/main/DISCLAIMER.md).
