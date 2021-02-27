Feature: Inventory Management
  As an Assistant I want to create an inventory to update the quantities of each articles

  Background:
    Given I am a user
      | username | email          | role      |
      | Laurent  | lq@example.com | Assistant |
    And I am an "Assistant"
    And the date is the last day of
      | date       | test  |
      | 2021-01-17 | week  |
      | 2021-01-31 | month |
    And there is an articles list for inventory
      | label   | theoreticalStock | price |
      | tomato  | 5.00             | 0.85  |
      | carotte | 0.00             | 0.53  |
      | potato  | 0.00             | 0.27  |

  Scenario: Prepare an Inventory
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
    Given an inventory exist
    When I want to enter inventory quantities
      | label   | stock |
      | tomato  | 3.00  |
      | carotte | 3.00  |
      | potato  | 8.00  |
    Then I should see the list of gaps ordered by "gap"
      | label   | gap   | amount |
      | potato  | -8.00 | -2.16  |
      | carotte | -3.00 | -1.59  |
      | tomato  |  2.00 |  1.70  |
    Then I should see the list of gaps ordered by "amount"
      | label   | gap   | amount |
      | potato  | -8.00 | -2.16  |
      | carotte | -3.00 | -1.59  |
      | tomato  |  2.00 |  1.70  |

  Scenario: Compare and correct
    Given an inventory exist
    And I want to enter inventory quantities
      | label   | stock |
      | tomato  | 3.00  |
      | carotte | 3.00  |
      | potato  | 8.00  |
    And I should see the list of gaps ordered by "gap"
      | label   | gap   | amount |
      | potato  | -8.00 | -2.16  |
      | carotte | -3.00 | -1.59  |
      | tomato  |  2.00 |  1.70  |
    When I see bad gaps
    And I correct the needed quantities
      | label   | stock |
      | tomato  | 5.00  |
      | potato  | 5.00  |
    Then the gaps are valid
      | label   | gap   | amount |
      | potato  | -5.00 | -1.35  |
      | carotte | -3.00 | -1.59  |

  Scenario: Valid the Inventory
    Given an inventory exist
    And I want to enter inventory quantities
      | label   | stock |
      | tomato  | 5.00  |
      | carotte | 3.00  |
      | potato  | 5.00  |
    And the gaps are valid
      | label   | gap   | amount |
      | potato  | -5.00 | -1.35  |
      | carotte | -3.00 | -1.59  |
    When I valid the inventory
    Then the quantity of articles is updated
      | label   | theoreticalStock | stock | price |
      | tomato  | 5.00             | 0     | 0.85  |
      | carotte | 3.00             | 0     | 0.53  |
      | potato  | 5.00             | 0     | 0.27  |
