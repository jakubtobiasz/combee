@ordering
Feature: Adding products to cart
  In order to buy products
  As a customer
  I need to be able to add products to the cart

  Background:
    Given there is a product with SKU "mug" priced at "12.00 EUR"
    And there is a product with SKU "shirt" priced at "20.00 EUR"

  @application
  Scenario: Adding a product to the cart (merging SKUs strategy)
    Given I have already picked up a cart
    When I add a single "mug" product to the cart
    And I add 3 items of the "shirt" product to the cart
    Then I should see 4 items in the cart
