document.addEventListener("DOMContentLoaded", function() {
  fetch("league.json")
      .then(response => response.json())
      .then(data => {
          const teamData = data.teams;
          const scorerData = data.topScorers;
          teamData.sort((a, b) => b.points - a.points); // Sort teams by points
          assignPositions(teamData); // Assign positions dynamically
          const table1 = generateTable(teamData, "Team Rankings", true);
          const table2 = generateTable(scorerData, "Top Scorers", false);
          const placeholder1 = document.querySelector("#team-rankings");
          const placeholder2 = document.querySelector("#top-scorers");
          placeholder1.appendChild(table1);
          placeholder2.appendChild(table2);
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
  const headers = includeExtraColumns ? ["Position", "Team", "Played Games", "Goal Difference", "Points"] : ["Team/Player", "Goals", "Assists", "PlayedP", "Goals per 90", "Mins per Goal", "Total Shots", "Goal Conversion", "Shot Accuracy"];
  
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
