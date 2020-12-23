Feature: Configure the company
  In order to use the application
  A company must to be added

  Scenario: Create a company
    When I visit page "/administration/company/new"
    And enter company data for "/administration/company/create" url
      | name | address | zipCode | town | country | phone | facsimile | email | contact | gsm |
      | Dev-int Création | 5, rue des ERP | 75000 | Paris | France | +33100000001 | +33100000002 | contact@gmail.com | Laurent | +33600000001 |
    Then return status code 202
