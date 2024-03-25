Feature: Create a new category
  In order to have categories on the platform
  As a user with admin permissions
  I want to create a new category

  Scenario: A valid non existing category
    Given I send a PUT request to "/categories/fb470470-b9d7-49eb-b9e1-89c5b04690ee" with body:
    """
    {
      "name": "The best category"
    }
    """
    Then the response status code should be 201
    And the response should be empty
