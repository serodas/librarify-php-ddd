Feature: Create a new author
  In order to have authors on the platform
  As a user with admin permissions
  I want to create a new author

  Scenario: A valid non existing author
    Given I send a PUT request to "/authors/1aab45ba-3c7a-4344-8936-78466eca77fa" with body:
    """
    {
      "name": "The best author"
    }
    """
    Then the response status code should be 201
    And the response should be empty
