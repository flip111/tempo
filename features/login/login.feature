@backend
Feature: Check login

  Scenario: Check login page when not connected
    When I go to "login"
    Then the response status code should be 200
    And I should see "Login"

  Scenario: Check user login page when connected
    When I am connected with "admin" and "admin" on "login"
    Then I should be on "login"
    And I should see "across"