Feature: Inventory Management
  As an Assistant I want to create an inventory to update the quantities of each articles

  Background:
    Given I am a user
      | username | email          | role      |
      | Laurent  | lq@example.com | Assistant |
      And I am an "Assistant"
      And there is an articles list
        | label   | theoreticalStock | price |
        | tomato  | 5.00             | 0.85  |
        | carotte | 0.00             | 0.53  |
        | potato  | 0.00             | 0.27  |

  Scenario: Prepare an Inventory
    Given the date is the last day of
      | date       | test  |
      | 2021-01-17 | week  |
      | 2021-01-31 | month |
    When I want to prepare an inventory
      And order by
        | order       |
        | zoneStorage |
        | all         |
    Then I should see the list of articles
      | label   | theoreticalStock | price |
      | tomato  | 5.00             | 0.85  |
      | carotte | 0.00             | 0.53  |
      | potato  | 0.00             | 0.27  |


  Scenario: Enter the quantities
    Given the date is the last day of
      | date       | test  |
      | 2021-01-17 | week  |
      | 2021-01-31 | month |
      And an inventory exist
    When I want to enter quantities
      | label   | stock |
      | carotte | 5.00  |
      | mais    | 3.00  |
      | potato  | 8.00  |
    Then I should see the list of gaps
      | label   | gap  | amount |
      | carotte | 3.00 | 1.59   |
      | potato  | 8.00 | 2.16   |
