## Day 2 - Constructors Continued <!--links--> &nbsp; [⬅️](../01-Day/01-Day-LessonPlan.md) &nbsp; [➡️](../03-Day/03-Day-LessonPlan.md)

### Overview

We will be going over how to use connector functions to link two objects together.

`Summary: Complete Activities 8-15 in Unit 11`

##### Instructor Priorities

After today's class, students should be able to:

* Use constructor functions to link two different objects together

* Sketch the architecture of small applications at a high level prior to writing code;

  * Implement applications with "clean" architectures;

* Use objects to consolidate related information;

* Use constructors to create those objects;

##### Instructor Notes

* Demonstrate the use of constructors in a multi-part application in preparation for the homework assignment.

* Have your TAs refer to the [Time Tracker](02-Day-TimeTracker.xlsx) to stay on track.

### Sample Class Video (Highly Recommended)
* To view an example class lecture visit (Note video may not reflect latest lesson plan): [Class Video](https://codingbootcamp.hosted.panopto.com/Panopto/Pages/Viewer.aspx?id=d4404449-a36d-4dc9-aaa4-44cf64ff824b)

---

### Class Objectives

* To feel 100% comfortable using javascript constructors
* To create simple applications that take in user input and utilize a constructor so as to create objects
* To understand the basics of recursion and to learn how this process can be used to loop through a series of prompts multiple times

* Sketch the design of their applications _before_ they start to code;

* Use constructors to create objects

---

### 1. Welcome Class (5 min)

* Welcome the class back and have them open up the team manager application from last time, and ask them how they did.

### 2. Everyone Do: Team Manager Summary: Part 1 (10 min)

* Open up `teamManager-basic.js` in `08-TeamManager` within your editor and start to go over the code with your students. This file contains only the first part of the assignment which prints players' stats to the screen, but should help them to understand how to better create and use constructor functions with inquirer.

* Once you have finished, have them return to their code in an attempt to complete the second part of the Team Manager activity

### 3. Students Do: Team Manager Cont. (20 min)

* Have your students work on the second part of the activity. If some students seem to be struggling, have them work alongside students who are moving along at a good pace or help them out yourself.

### 4. Everyone Do: Team Manager Summary: Part 2 (15 min)

* Open up `teamManager-advanced.js` in `08-TeamManager` within your editor and work through the code with your students. Let them know that they should not worry if they managed to complete the first part of the activity but then struggled to complete the second half. So long as they understand the first part of the activity and can follow along with the second part, they are in good shape.

### 5. Instructor Do: Constructors Within Constructors (10 min)

* So far we have held our constructed objects within arrays to great affect, but what if we wanted to call upon those constructed objects within another object? What would we do then?

* Well, as it turns out, we can actually nest a constructor within another constructor fairly easily. In fact, it operates very similarly to creating a method within a constructor.

* Open up the folder `09-MovieManager` within your editor and show your students how we are exporting a constructor function from one file - `castMember.js` for example - and calling upon it within another; in this case `movie.js`

* What's more, we are then able to add objects created from the `CastMember` constructor into the `cast` array inside of the object created by the `Movie` constructor.

  * Open up `main.js` walk the class through the code and show them the terminal output.

* Answer any questions about this demonstration before moving on to the next activity.

### 6. Students Do: Filling Up Classrooms (15 min)

* Answer any questions your students might have before slacking out the following instructions...

* **Instructions**

  * In this activity we are going to make two constructors in two different files in which one constructor calls upon the other within it.

  * The first constructor function is called "Student" and has the following properties within it...

    * Name of the student
    * Favorite subject
    * Current GPA

  * The second constructor function is called "Class" and has the following properties within it...

    * An array of students within the class
    * Number of students in the class
    * Name of the professor
    * Room number
    * The Student constructor function from above which adds a new student to the class

  * BONUS: Make it so that that your application can take in user input to add new classes and new students to those classes.

### 7. Instructor Do: Demonstrate Application (5 min)

* Take a moment to demonstrate the `11-Completed-WeatherAdmin` application that students will be building.

  * Be sure to demonstrate both the user search and admin view functionalities.

  * Explain that the command-line application decides which logic to execute based on whether the user indicates search or admin usage on the command-line.

* Explain that we'll proceed step-by-step. Students will:

  * Write out a high-level application architecture;

  * Implement the user search logic `UserSearch.js` in `11-Completed-WeatherAdmin`.

  * Implement the admin view logic `WeatherAdmin.js` in `11-Completed-WeatherAdmin`.

  * Implement the CLI decision logic `CLI.js` in `11-Completed-WeatherAdmin`, tying it all together.

### 8. Partners Do: Sketch Architecture (15 min)

---

**Objectives Met**

* Sketch the architecture of small applications at a high level prior to writing code;

---

* Remind students that the application:

  * Accepts command-line arguments indicating whether the user intends to search or retrieve an Admin view;

  * Makes an API request in the event of user search; and

  * Displays a list of previous searches in the event that the user wants the admin view.

* Slack out the following instructions to students.

  * **Instructions**:

    * As a best practice, sketch the architecture of your application _before_ you start writing code.

    * For this exercise, start by describing what your application does. Do this in a bullet list.

    * Next, decide how you might divvy up these responsibilities. Would you write a single module that handles all of them? Would you write one module for each bullet list? Something else? Be sure to justify your decision.

    * Finally, draw a diagram describing the relationships between your modules. Each arrow should describe a dependency—that is, an arrow from module A to module B indicates that module A uses module B.

### 9. Instructor Do: Review Activity (5 min)

* Ask a group to:

  * Share their bullet list;

  * Describe the components they would define; and

  * Explain why they would define their modules this way.

* Briefly discuss the pros and cons of their solution.

* Present the `solution.md` file in `12-Architecture/Solved`, and explain why we've chosen to structure the application as such.

![A high-level, diagram view of our Weather Admin application.](Images/1-weather-admin.png)

_A high-level, diagram view of our Weather Admin application._

### 10. Partners Do: Implement UserSearch (0:40)

---

**Objectives Met**

* Use objects to consolidate related information;

* Use constructors to create those objects;

---

* Inform the class that we're going to start with the `UserSearch` module, since it's self-contained and doesn't depend on any other code we haven't written yet.

* Slack out the following instructions.

  * **Instructions**:

    * Implement the logic for the `UserSearch` component. You should begin planning the component with pseudocode.

    * This component requires you to use the `weather-js` NPM package. Take a moment to research and experiment with the API, documented here: <https://www.npmjs.com/package/weather-js>

    * Create a `UserSearch` constructor. It should accept a user's name and location as arguments, and store the value of `Date.now()` in a `date` property. (This will be formatted later.)

    * Objects returned by the `UserSearch` constructor should also have a `getWeather` method, which should log or return the weather in the user's location.

    * Test your UserSearch constructor by feeding it dummy data for now.

### 11. Instructor Do: Review Activity (0:10)

* Open up the `UserSearch.js` in `13-UserSearch/Solved`, and walk through the solution. Emphasize:

  * The use of `this` and property setting; and

  * The logic behind `getWeather`.

* Slack out the solution so students can use it as as starting point as they move forward.

---

### 12. Lunch (30 min)

---

### 13. Partners Do: Implement WeatherAdmin (0:40)

---

**Objectives Met**

* Use objects to consolidate related information;

* Use constructors to create those objects;

---

* Slack out the following instructions.

  * **Instructions**:

    * Implement the logic for the `WeatherAdmin` component. As with the `UserSearch` component, you should start with pseudocode.

    * This component requires you to read and save information. Be sure to `require` the appropriate Node package.

    * Create a `WeatherAdmin` constructor. This constructor should return an object with two methods.

    * One of those methods is `newUserSearch`, which should accept a user's `name` and `location`; search for the weather in their area; and save the user's information in a log of all searches users have made thus far. Don't forget to format the date before saving it. (It's simple, and it only takes a... _moment_!)

    * The other method is `getData`, which should log or return a list of all of the searches users have executed thus far.

    * Test the `WeatherAdmin` component by feeding it dummy data for now.

### 14. Instructor Do: Review Activity (0:10)

* Open up the `WeatherAdmin.js` in `14-WeatherAdmin/Solved`, and walk through the solution. Emphasize:

  * Reading and writing files with `fs`; and

  * The notion of **composition**, exemplified by our use of `UserSearch` within `WeatherAdmin`'s `newUserSearch` method.

* Slack out the solution so students can use it as as starting point as they move forward.

### 15. Partners Do: Implement CLI (0:15)

---

**Objectives Met**

* Implement applications with "clean" architectures;

---

* Slack out the following instructions.

  * **Instructions**:

    * Implement the logic for the CLI component. Refer to the architectural diagram for help.

    * Before you write any JavaScript, write out the CLI component's behavior in pseudocode.

    * Be sure to require the `WeatherAdmin` module here.

    * When you're finished, ask the instructor or one of your TAs to approve your solution.

    * **Hint**: This component doesn't require much code.

### 16. Instructor Do: Review Activity (0:05)

* Open up the `CLI.js` inside `15-CLI/Solved` file, and walk through the solution.

* Slack out the solution, but if students are confident in their own solutions, they're free to use them.

### 17. Everyone Do: Application Review (0:10)

* Demonstrate the completed application, and have students follow along.

* Foster discussion around the benefits of planning an architecture before writing any code.

  * Also discuss any possible improvements.

* Take this time to address any outstanding questions students may have.

### 18. Groups Do: Homework (10 min)

* Put students into groups to work on homework.
