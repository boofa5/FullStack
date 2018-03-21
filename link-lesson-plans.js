const Rx = require('rxjs')
const fs = require('fs')
const pathLib = require('path')
const glob = require('glob-promise')
const leftPad = require('left-pad')
const { execSync } = require('child_process')

const getLinks = (path, schedule) => {
  if (!path.match) return
  let pattern =
    schedule === 'part-time'
      ? /.*part-time\/(\d\d)-Week\/(\d\d)-Day\/\d\d-(Day-.*md)/
      : /.*full-time\/(\d\d)-Week\/(\d\d)-Day\/\d\d-(Day-.*md)/
  let [week, day] = path
    .match(pattern)
    .slice(1, 3) // indexes 1 and 2 are our week/day
    .map(x => parseInt(x)) // doesnt work in form .map(parseInt) - why?

  let restOfFile = path.match(pattern)[3]

  let lastOfWeek = schedule === 'part-time' ? 3 : 5

  let prevWeek = leftPad(day === 1 ? week - 1 : week, 2, '0')
  let nextWeek = leftPad(day === lastOfWeek ? week + 1 : week, 2, '0')
  let prevDay = leftPad(day === 1 ? lastOfWeek : day - 1, 2, '0')
  let nextDay = leftPad(day === lastOfWeek ? 1 : day + 1, 2, '0')

  let prevPath =
    day === 1
      ? `../../${prevWeek}-Week/${prevDay}-Day/${prevDay}-${restOfFile}`
      : `../${prevDay}-Day/${prevDay}-${restOfFile}`

  let nextPath =
    day === lastOfWeek
      ? `../../${nextWeek}-Week/${nextDay}-Day/${nextDay}-${restOfFile}`
      : `../${nextDay}-Day/${nextDay}-${restOfFile}`

  // Start our return object, though we may delete its links
  let retObj = { prev: prevPath, next: nextPath }

  // There is no week 00
  if (prevWeek === '00') {
    delete retObj.prev
  }

  // There is no week 13 FT
  if (nextWeek === '13' && schedule === 'full-time') {
    delete retObj.next
  }
  // There is no week 25 PT
  if (nextWeek === '25' && schedule === 'part-time') {
    delete retObj.next
  }

  // Delete paths if files not found
  if (retObj.next) {
    if (!fs.existsSync(pathLib.join(pathLib.dirname(path), retObj.next))) {
      console.log('would unlink file' + retObj.next)
      delete retObj.next
    }
  }
  if (retObj.prev) {
    if (!fs.existsSync(pathLib.join(pathLib.dirname(path), retObj.prev))) {
      console.log('would unlink file' + retObj.prev)
      delete retObj.prev
    }
  }

  // done, return it
  return retObj
}

async function runIt(schedule = 'full-time') {
  Rx.Observable
    // path questions
    // some inconsistent names plan.md vs Plan.md(upper-case in minority)
    // nested folders like part-time/21-Week/C#
    .from(await glob(`02-lesson-plans/${schedule}/*-Week/*-Day/*lan.md`))
    .do(x => console.log(x))
    .map(path => Object.assign({ path }, getLinks(path, schedule)))
    .do(({ path, prev, next }) => {
      var body = fs.readFileSync(path, 'utf8')
      var prevLink = prev ? `[⬅️](${prev})` : ''
      var nextLink = next ? `[➡️](${next})` : ''
      var linkedBody = body.replace(
        /(\s*<!--links-->.*)?\n/, // at the first newline
        ` <!--links--> &nbsp; ${prevLink} &nbsp; ${nextLink}\n`
      )
      if (linkedBody !== body) {
        fs.writeFileSync(path, linkedBody)
      }
    })
    .subscribe()
}

async function normalizeFiles() {
  let badOnes = await glob(`02-lesson-plans/*/*-Week/*-Day/*plan.md`)
  // console.log(badOnes)
  badOnes.forEach(lowerCaseFile => {
    let correctCase = lowerCaseFile.replace('Lessonplan.md', 'LessonPlan.md')
    if (lowerCaseFile !== correctCase) {
      execSync(
        // haha this slayed me! https://stackoverflow.com/questions/3011625/git-mv-and-only-change-case-of-directory/3011723#3011723
        `git mv ${lowerCaseFile} tmp.md && git mv tmp.md ${correctCase}`
      )
    }
  })
}

function updateReadmeLinks() {
  execSync(
    "git grep -l Lessonplan.md 02-lesson-plans/ | xargs sed -i '' 's/Lessonplan.md/LessonPlan.md/g'"
  )
}

// npm run link-lesson-plans -- normalizeFiles
// Run with git config core.ignorecase false!
if (process.argv[2] === 'normalizeFiles') {
  execSync('git config core.ignorecase false')
  normalizeFiles()
  updateReadmeLinks()
  execSync('git add .')
} else {
  // npm run link-lesson-plans
  runIt('full-time')
  runIt('part-time')
}
