Feature: Prepare inventory
  In order to print an inventory
  As a user
  I must visit the inventory prepare page

  Scenario: I want to print an inventory
    When I visit page "/inventory/prepare"
    Then it should return a "file"
