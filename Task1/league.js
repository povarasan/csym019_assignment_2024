document.addEventListener("DOMContentLoaded", function() {
    fetch("league.json")
        .then(response => response.json())
        .then(data => {
            const fixtures = data.fixtures;
            const footballTeamData = data.teams;
            const scorerData = data.topScorers;
            console.log("fixtures", fixtures);

            // Sort teams by points
            footballTeamData.sort((a, b) => b.points - a.points);
            // Assign positions dynamically
            assignPositions(footballTeamData);

            // Sort scorers by goals
            scorerData.sort((a, b) => b.goals - a.goals);
            // Assign positions to top scorers
            assignPositions(scorerData);

            // Generate tables for team rankings and top scorers
            const teamTable = tableContainer(footballTeamData, "", true);
            const scorerTable = tableContainer(scorerData, "", false);

            // Append tables to placeholders
            const team = document.querySelector("#team-rankings");
            const scorer = document.querySelector("#top-scorers");
            const fixture = document.querySelector("#fixtures-table");

            if (team) {
                team.appendChild(teamTable);
            } else {
                console.error('Team rankings placeholder not found.');
            }

            if (scorer) {
                scorer.appendChild(scorerTable);
            } else {
                console.error('Top scorers placeholder not found.');
            }

            if (fixture) {
                // Generate fixture table
                const fixtureList = fixtureListContainer(fixtures);
                fixture.appendChild(fixtureList);
            } else {
                console.error('Fixtures table placeholder not found.');
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
});

// Generate table for fixture data
function fixtureListContainer(fixtures) {
    const table = document.createElement("table");
    table.className = "fixture-table";
    
    const headerRow = table.insertRow();
    const headers = ["Home Team", "Score", "Away Team"];
    
    headers.forEach(headerText => {
        const th = document.createElement("th");
        th.textContent = headerText;
        headerRow.appendChild(th);
    });
    
    fixtures.forEach(fixture => {
        const row = table.insertRow();
        
        const homeTeamCell = row.insertCell();
        homeTeamCell.textContent = fixture.homeTeam;
        
        const scoreCell = row.insertCell();
        scoreCell.textContent = `${fixture.homeScore} - ${fixture.awayScore}`;
        
        const awayTeamCell = row.insertCell();
        awayTeamCell.textContent = fixture.awayTeam;
    });
    
    return table;
}

// Generate table dynamically based on data
function tableContainer(data, title, includeExtraColumns) {
    const table = document.createElement("table");
    table.style.width = "100%";
    table.style.textAlign = "center"; // Center all content
    table.style.borderCollapse = "collapse"; // Collapse borders

    const caption = document.createElement("caption");
    caption.textContent = title;
    table.appendChild(caption);

    const headerRow = table.insertRow();
    const headers = includeExtraColumns 
        ? ["Position", "Team", "Played Games", "Won", "Drawn", "Lost", "Goal Difference", "Points", "Form"] 
        : ["Position","Player (Team)", "Goals", "Assists", "Played", "Goals per 90", "Mins per Goal", "Total Shots", "Goal Conversion", "Shot Accuracy"];

    headers.forEach(headerText => {
        const th = document.createElement("th");
        th.textContent = headerText;
        th.style.border = "1px solid #ddd"; // Optional: Add border for table header
        th.style.padding = "8px"; // Optional: Add padding for table header
        headerRow.appendChild(th);
    });

    data.forEach(item => {
        const row = table.insertRow();
        row.style.border = "1px solid #ddd"; // Optional: Add border for table row

        let rowData;

        if (item.name) {
            // Create a cell for the team logo and name
            const teamCell = row.insertCell();
            teamCell.style.display = "flex";
            teamCell.style.alignItems = "center";
            teamCell.style.justifyContent = "center"; // Center content

            // Create an image element for the logo
            const logo = document.createElement("img");
            logo.src = item.image;
            logo.alt = item.name;
            logo.style.maxWidth = "30px"; // Adjust the size as needed
            logo.style.marginRight = "8px"; // Space between image and text

            // Append the logo and team name to the cell
            teamCell.appendChild(logo);
            teamCell.appendChild(document.createTextNode(item.name));

            const formIcons = createFormIcons(item.lastSixGames);

            rowData = [item.position, teamCell, item.playedGames, item.won, item.drawn, item.lost, item.goalDifference, item.points, formIcons];
        } else {
            rowData = [item.position,`${item.player} (${item.team})`, item.goals, item.assists, item.played, item.goalsPer90, item.minsPerGoal, item.totalShots, item.goalConversion, item.shotAccuracy];
        }

        rowData.forEach(dataItem => {
            const cell = row.insertCell();
            if (dataItem instanceof Node) {
                cell.appendChild(dataItem);
            } else {
                cell.textContent = dataItem;
            }
            cell.style.padding = "8px"; // Add padding for all cells
        });
    });

    return table;
}

// Create form icons based on last six games
function createFormIcons(lastSixGames) {
    const container = document.createElement("div");
    container.style.display = "flex";
    container.style.justifyContent = "center"; // Center icons

    lastSixGames.split('').forEach(game => {
        const icon = document.createElement("span");
        icon.style.display = "inline-block";
        icon.style.width = "10px";
        icon.style.height = "10px";
        icon.style.marginRight = "2px";
        icon.style.borderRadius = "50%";

        if (game === 'W') {
            icon.style.backgroundColor = "green";
        } else if (game === 'L') {
            icon.style.backgroundColor = "blue";
        }
        container.appendChild(icon);
    });
    return container;
}

// Assign positions based on sorted data
function assignPositions(data) {
    data.forEach((item, index) => {
        item.position = index + 1;
    });
}
