Feature: Order Management
  As an Assistant I want to place an order to buy the articles necessary for the operation of the restaurant

  Background:
    Given I am a user
      | username | email          | role      |
      | Laurent  | lq@example.com | Assistant |
    And I am an "Assistant"
    And there is a suppliers list
      | name      | address          | email              | orderDays |
      | Davigel   | 3 rue des Freeze | order@davigel.fr   | 1,4       |
      | Davifrais | 8 rue des Fresh  | order@davifrais.fr | 2,5       |
    And there is an articles list for order
      | label   | supplier  | quantity | quantityToOrder | minimumStock | price |
      | tomato  | Davigel   | 5.00     | 0.00            | 8.50         | 0.85  |
      | carotte | Davigel   | 3.00     | 0.00            | 5.00         | 0.53  |
      | potato  | Davifrais | 2.50     | 0.00            | 3.00         | 0.27  |

  Scenario: Create Order
    When I have to choose the supplier
      | name    |
      | Davigel |
    And I have to choose the order date
      | date       |
      | 2021-03-01 |
    And I want to create an order
    Then I should see the list of supplier articles
      | label   | supplier  | quantity | quantityToOrder | minimumStock | price |
      | tomato  | Davigel   | 5.00     | 3.50            | 8.50         | 0.85  |
      | carotte | Davigel   | 3.00     | 2.00            | 5.00         | 0.53  |

  Scenario: Enter quantities
    Given I have to choose the supplier
      | name    |
      | Davigel |
    And I have to choose the order date
      | date       |
      | 2021-03-01 |
    And an order exist
    When I enter order quantities
      | label   | quantityToOrder |
      | tomato  | 6.00            |
      | carotte | 5.50            |
    Then I should see the list of supplier articles
      | label   | supplier  | quantity | quantityToOrder | minimumStock | price |
      | tomato  | Davigel   | 5.00     | 6.00            | 8.50         | 0.85  |
      | carotte | Davigel   | 3.00     | 5.50            | 5.00         | 0.53  |
