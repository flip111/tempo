@backend
Feature: Check login

  Scenario: Check login page when not connected
    When I go to "login"
    Then the response status code should be 200
    And I should see "Login"