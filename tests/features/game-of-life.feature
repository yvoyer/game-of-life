Feature:
  As a console user
  In order to see the evolution of a virtual life
  I need to see the world evolve

  Background:
    Given The live cell representation is '*'
    And The dead cell representation is '-'

  Scenario: Kill a cell with no cells around
    Given I have the following world:
      | 1 | 2 | 3 |
      | - | - | - |
      | - | * | * |
      | - | * | - |
    When I run the simulation
    Then The world should look like:
    """
---
---
---
"""
    And The iteration count should be 1

  Scenario: Cell survive when at least 3 cell active around
    Given I have the following world:
      | 1 | 2 | 3 |
      | - | - | - |
      | * | - | * |
      | - | * | - |
    When I run the simulation
    Then The world should look like:
    """
---
-*-
---
"""
    And The iteration count should be 1
