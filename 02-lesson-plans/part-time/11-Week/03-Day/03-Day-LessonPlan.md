# 11.3 Lesson Plan—Callbacks & Constructors in the Wild <!--links--> &nbsp; [⬅️](../02-Day/02-Day-LessonPlan.md) &nbsp; [➡️](../../12-Week/01-Day/01-Day-LessonPlan.md)

### Overview

Today's lesson plan will consolidate students' understanding of constructors and formalize the concept of callbacks.

`Summary: Complete activities 11-16 in Unit 11`

##### Attention: If you’re teaching a part time section and this isn’t a Saturday, please use the “Weekday” tab inside of the "03-Day-TimeTracker.xlsx" for activity lengths instead of those printed on this lesson plan

#### Instructor Priorities

After today's class, students should be able to:

* Sketch the architecture of small applications at a high level prior to writing code;

  * Implement applications with "clean" architectures;

* Use objects to consolidate related information;

* Use constructors to create those objects;

* Articulate the relationship between callbacks and functions that receive them as arguments.

#### Instructor Notes

* The purpose of today's class is to demonstrate the use of constructors in a multi-part application in preparation for the week's homework assignment.

  * Building the Weather Admin application is the focus of today's lesson. Feel free to cut the callback activity and closure sections if required.

* Have your TAs refer to the [Time Tracker](03-Day-TimeTracker.xlsx) to stay on track.

### Sample Class Video (Highly Recommended)
* To view an example class lecture visit (Note video may not reflect latest lesson plan): 
[Class Video 1](https://codingbootcamp.hosted.panopto.com/Panopto/Pages/Viewer.aspx?id=36c45a35-9dd9-4099-80df-819a318585d1)
[Class Video 2](https://codingbootcamp.hosted.panopto.com/Panopto/Pages/Viewer.aspx?id=48341f00-9d7f-4d69-892f-b1315ad93c4f)

---

### Class Objectives

After today's class, students will be able to:

* Sketch the design of their applications _before_ they start to code;

* Use constructors to create objects; and

* Explain callbacks and closures.

---

### 1. Instructor Do: Demonstrate Application (0:05)

* Take a moment to demonstrate the `11-Completed-WeatherAdmin` application that students will be building.

  * Be sure to demonstrate both the user search and admin view functionalities.

  * Explain that the command-line application decides which logic to execute based on whether the user indicates search or admin usage on the command-line.

* Explain that we'll proceed step-by-step. Students will:

  * Write out a high-level application architecture;

  * Implement the user search logic `UserSearch.js` in `11-Completed-WeatherAdmin`.

  * Implement the admin view logic `WeatherAdmin.js` in `11-Completed-WeatherAdmin`.

  * Implement the CLI decision logic `CLI.js` in `11-Completed-WeatherAdmin`, tying it all together.

### 2. Partners Do: Sketch Architecture (0:15)

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

### 3. Instructor Do: Review Activity (0:05)

* Ask a group to:

  * Share their bullet list;

  * Describe the components they would define; and

  * Explain why they would define their modules this way.

* Briefly discuss the pros and cons of their solution.

* Present the `solution.md` file in `12-Architecture/Solved`, and explain why we've chosen to structure the application as such.

![A high-level, diagram view of our Weather Admin application.](Images/1-weather-admin.png)

_A high-level, diagram view of our Weather Admin application._

### 4. Partners Do: Implement UserSearch (0:40)

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

### 5. Instructor Do: Review Activity (0:10)

* Open up the `UserSearch.js` in `13-UserSearch/Solved`, and walk through the solution. Emphasize:

  * The use of `this` and property setting; and

  * The logic behind `getWeather`.

* Slack out the solution so students can use it as as starting point as they move forward.

### 6. Partners Do: Implement WeatherAdmin (0:40)

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

### 7. Instructor Do: Review Activity (0:10)

* Open up the `WeatherAdmin.js` in `14-WeatherAdmin/Solved`, and walk through the solution. Emphasize:

  * Reading and writing files with `fs`; and

  * The notion of **composition**, exemplified by our use of `UserSearch` within `WeatherAdmin`'s `newUserSearch` method.

* Slack out the solution so students can use it as as starting point as they move forward.

### 8. Partners Do: Implement CLI (0:15)

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

### 9. Instructor Do: Review Activity (0:05)

* Open up the `CLI.js` inside `15-CLI/Solved` file, and walk through the solution.

* Slack out the solution, but if students are confident in their own solutions, they're free to use them.

### 10. Everyone Do: Application Review (0:10)

* Demonstrate the completed application, and have students follow along.

* Foster discussion around the benefits of planning an architecture before writing any code.

  * Also discuss any possible improvements.

* Take this time to address any outstanding questions students may have.

---

### 11. BREAK (0:45)

---

### 12. Instructor Do: Callbacks (0:10)

**Objectives Met**

* Articulate the relationship between callbacks and functions that receive them as arguments.

---

* Remind students that we can assign functions as values to variables.

* Explain that, since functions are values, we can pass them as arguments to functions.

  * Point out that we've done just this in our implementation of `UserSearch`—specifically, in our call to `weather.find`.

* Explain that functions passed as arguments to other functions are called **callbacks**.

  * Explain that this is because we typically intend for the function _receiving_ the callback to do some work, and then **call back** the function we pass with its results.

  * Explain what happens when we call `weather.find`:

    * First, `weather.find` executes a search for the weather in the user's `location`, and reports results in the `degreeFormat` we specify.

    * Then, one of two things happens. Either:

      * `weather.find` hits an error in its search. In this case, _it calls the function we've given it with an **error** argument_.

      * `weather.find` finds the data it wants. In this case, _it calls the function we've given it and passes it that data as an argument_.

    * In either case, the `weather.find` function does some work, and then **calls us back** with the result.

  * Explain that this allows us to write code that deals with values we don't have yet—in this case, the weather data—which will run _later_, when we _do_ have those values.

### 13. Students Do: Callbacks Activity (0:10)

* Slack out the following instructions.

  * **Instructions**:

    * Write a function that accepts a string and a function as arguments. It should log the string, and then run the function.

    * Write a function that accepts a boolean value and a function as arguments. It should run the function if and only if the boolean argument is true.

    * Write a function that accepts a function (F) and a value (V), and returns a function that returns the result of running F on V. This sounds tricky, but it's easier than it sounds—just take it step by step!

    * Finally, write a short message to a file using `fs.writeFile`. Does this function use callbacks? If so, identify them.

### 14. Instructor Do: Review Activity (0:05)

* Open up `callbacks.js` in `16-Callbacks/Solved`, and step through the solution.

  * Pay special attention to:

    * Explaining that, in each example, `func` is a value that contains a **function**. This is why we can put parentheses after it—this _calls_ the function.

    * Explaining that, when we pass a function a callback, we can do other work _before_ we call the callback. This allows us to reuse functions we already have, but **decorate** them but doing "extra stuff".

      * Briefly explain the notion of function decoration.

* Emphasize that students have been using callbacks from the beginning of their JavaScript studies. Today's lesson simply associates the concept with a name.

* Slack out the solutions and take a few moments to answer outstanding questions.
