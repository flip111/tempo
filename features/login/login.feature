@account
Feature: Check login

  Scenario: Check login page when not connected
    When I go to "/login"
    Then the response status code should be 200
    And I should see "Login"


  Scenario: Check user login page when connected
    When I fill in "Username" with "admin"
    And I fill in "Password" with "admin"
    And I press "Login"