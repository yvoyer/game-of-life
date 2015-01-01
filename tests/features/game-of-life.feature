Feature:
  As a console user
  In order to see the evolution of a virtual life
  I need to see the world evolve

  Background:
    Given The live cell representation is '*'
    And The dead cell representation is '-'

  Scenario: Should supports Blinkers
    Given I have the following world:
      | 1 | 2 | 3 | 4 | 5 |
      | - | - | - | - | - |
      | - | - | - | - | - |
      | - | * | * | * | - |
      | - | - | - | - | - |
      | - | - | - | - | - |
    When I run the simulation with 1 iteration
    Then The world should look like:
    """
-----
--*--
--*--
--*--
-----
"""
    And The iteration count should be 1

  Scenario: Should supports Beacon
    Given I have the following world:
      | 1 | 2 | 3 | 4 | 5 | 6 |
      | - | - | - | - | - | - |
      | - | * | * | - | - | - |
      | - | * | - | - | - | - |
      | - | - | - | - | * | - |
      | - | - | - | * | * | - |
      | - | - | - | - | - | - |
    When I run the simulation with 1 iteration
    Then The world should look like:
    """
------
-**---
-**---
---**-
---**-
------
"""
    And The iteration count should be 1

  Scenario: Should supports Glider
    Given I have the following world:
      | 1 | 2 | 3 | 4 | 5 | 6 |
      | * | - | - | - | - | - |
      | - | * | * | - | - | - |
      | * | * | - | - | - | - |
      | - | - | - | - | - | - |
      | - | - | - | - | - | - |
      | - | - | - | - | - | - |
    When I run the simulation with 3 iteration
    Then The world should look like:
    """
------
--*---
*-*---
-**---
------
------
"""
    And The iteration count should be 3
