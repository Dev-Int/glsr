Feature: Configure the users
  In order to use the application
  A user must to be added

  Scenario: Create a user
    When I visit page "/administration/user/new"
    And enter user data for "/administration/user/create" url
      | username | email | password | confirm-password | roles |
      | Laurent | laurent@example.com | password | password | [admin] |
    Then return status code 202
