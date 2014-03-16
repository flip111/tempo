@dashboard
Feature: dashboard project

  Background:
    Given I am connected as "admin"

  Scenario: Viewing the dashboard project
    When I am on route "project_home"

    And I should see "Select the organization"
    Then I should see 6 "#organizations ul.list li" elements
