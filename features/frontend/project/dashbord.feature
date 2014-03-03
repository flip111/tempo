@dashboard
Feature: dashboard project

  Background:
    Given I am connected as "john.doe"

  Scenario: Viewing the dashboard project
    When I am on route "project_home"

    And I should see "Select the organization"
    Then I should see 5 "#organizations ul.list li" elements
