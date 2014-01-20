Feature: Create Organisation

  Background:
    Given I am connected as "admin"

  Scenario: Create a organisation
    Given I am on route "project_home"
    When I follow "Add new organization"
    And I should see the modal "Add new organization"
    And I fill in "Name" with "Toto"
    And I press "Save"