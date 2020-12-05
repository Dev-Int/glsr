Feature: Prepare inventory
  In order to print an inventory
  As a user
  I must visit the inventory prepare page

  Scenario: I want to print an inventory
    When I visit page "https://127.0.0.1:8000/inventory/prepare"
    Then it should return a file with title "Inventaire"
