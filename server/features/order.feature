Feature: Order Management
  As an Assistant I want to place an order to buy the articles necessary for the operation of the restaurant

  Background:
    Given I am a user
      | username | email          | role      |
      | Laurent  | lq@example.com | Assistant |
    And I am an "Assistant"
    And there is a suppliers list
      | name      | address          | email              |
      | Davigel   | 3 rue des Freeze | order@davigel.fr   |
      | Davifrais | 8 rue des Fresh  | order@davifrais.fr |
    And there is an articles list for order
      | label   | supplier  | price |
      | tomato  | Davigel   | 0.85  |
      | carotte | Davigel   | 0.53  |
      | potato  | Davifrais | 0.27  |

  Scenario: Create Order
    When I have to choose the supplier
      | name    |
      | Davigel |
    And I want to create an order
    Then I should see the list of supplier articles
      | label   | supplier  | price |
      | tomato  | Davigel   | 0.85  |
      | carotte | Davigel   | 0.53  |

