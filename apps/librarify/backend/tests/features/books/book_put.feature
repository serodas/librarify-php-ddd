Feature: Create a new book
  In order to have books on the platform
  As a user with admin permissions
  I want to create a new book

  Scenario: A valid non existing book
    Given I send a PUT request to "/books/ec811a12-6fa5-4f32-b48f-e4d3ada3708f" with body:
      """
      {
      "title": "The best book",
      "description": "The best book ever written by the best author",
      "score": 5,
      "authors": [
        "2493201f-195d-3b9d-b339-45a8ff81d595",
        "8847e899-f2ab-39f9-a870-7fc7ea87e829",
        "5722131a-3ba0-3f30-8d74-ba5fa08caba5"
      ],
      "categories": [
        "4d399f26-6f4c-3efc-8953-ce2bcaf04b0f"
      ]
      }
      """
    Then the response status code should be 201
    And the response should be empty
