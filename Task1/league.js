document.addEventListener("DOMContentLoaded", function() {
    fetch("league.json")
        .then(response => response.json())
        .then(data => {
            const teamData = data.teams;
            const scorerData = data.topScorers;
            teamData.sort((a, b) => b.points - a.points); // Sort teams by points
            assignPositions(teamData); // Assign positions dynamically
            scorerData.sort((a, b) => b.goals - a.goals); // Sort scorers by goals
            const table1 = generateTable(teamData,"", true);
            const table2 = generateTable(scorerData,"", false);
            const placeholder1 = document.querySelector("#team-rankings");
            const placeholder2 = document.querySelector("#top-scorers");
           
            if (placeholder1) {
                placeholder1.appendChild(table1);
            } else {
                console.error('Team rankings placeholder not found.');
            }
            if (placeholder2) {
                placeholder2.appendChild(table2);
            } else {
                console.error('Top scorers placeholder not found.');
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
});

function generateTable(data, title, includeExtraColumns) {
  const table = document.createElement("table");
  const caption = document.createElement("caption");
  caption.textContent = title;
  table.appendChild(caption);
  const headerRow = table.insertRow();
  const headers = includeExtraColumns ? ["Position", "Team", "Played Games", "Goal Difference", "Points"] : ["Player(Team)", "Goals", "Assists", "Played", "Goals per 90", "Mins per Goal", "Total Shots", "Goal Conversion", "Shot Accuracy"];
  
  headers.forEach(headerText => {
      const th = document.createElement("th");
      const text = document.createTextNode(headerText);
      th.appendChild(text);
      headerRow.appendChild(th);
  });

  data.forEach(item => {
      const row = table.insertRow();
      let rowData;
      if (item.name) {
          rowData = [item.position, item.name, item.playedGames, item.goalDifference, item.points];
      } else if (item.player) {
          rowData = [
              item.player + " (" + item.team + ")", 
              item.goals,
              item.assists,
              item.played,
              item.goalsPer90,
              item.minsPerGoal,
              item.totalShots,
              item.goalConversion,
              item.shotAccuracy
          ];
      }
      
      rowData.forEach(text => {
          const cell = row.insertCell();
          const cellText = document.createTextNode(text || "");
          cell.appendChild(cellText);
      });
  });

  return table;
}

function assignPositions(teams) {
  teams.forEach((team, index) => {
      team.position = index + 1;
  });
}
