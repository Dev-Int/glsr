Feature: Configure the company
  In order to use the application
  A company must to be added

  Scenario: Create a company
    When I visit page "https://127.0.0.1:8000/administration/company/new"
    And enter data:
      | name | address | zipCode | town | country | phone | facsimile | email | contact | gsm |
      | Dev-int Création | 5, rue des ERP | 75000 | Paris | France | +33100000001 | +33100000002 | contact@gmail.com | Laurent | +33600000001 |
    Then return status code 202
