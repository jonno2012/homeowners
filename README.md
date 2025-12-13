# Homeowner Names - Technical Test

Alongside this brief, you should have been given a file containing a list of names (examples.csv). This list is an example of the sort of data we can sometimes be working with - it’s some fake homeowners who might be interacting with one of our agents.

In this example, the agent has been entering multiple people’s names into a single field in their old system, meaning that each row can potentially refer to one or more people.

We’d like to convert this list into individual people records, with the following schema:

- **title** - required
- **first_name** - optional
- **initial** - optional
- **last_name** - required

To complete this test, please write an application that can accept the CSV and output the list as a set of individual people, splitting the name into the correct fields, and converting into multiple people where necessary. This list should be returned in JSON format.

We do not expect you to handle any cases other than the ones given in the example csv to pass the requirements.

Create a simple class that loads the CSV from the filesystem. Data storage is not required - we’re happy to have stateless applications that return the data on request.

*We do not expect people to spend more than around 2 hours on this task.*


## Example Output

```json
[
  {
    "title": "Mr",
    "first_name": "John",
    "last_name": "Smith",
    "initial": null,
  },
  {
    "title": "Mrs",
    "first_name": "Jane",
    "last_name": "Smith",
    "initial": null,
  },
  {
    "title": "Mr",
    "first_name": "Tom",
    "last_name": "Staff",
    "initial": null
  },
  {
    "title": "Mr",
    "first_name": "John",
    "last_name": "Doe",
    "initial": null,
  },
  {
    "title": "Mr",
    "first_name": null,
    "last_name": "Fredrickson",
    "initial": "F"
  }
]
```

## Use external libraries if necessary, adding packages to the composer.json file where necessary.
