<!DOCTYPE html>
<html>
<head>
    <title>Relevé de Notes</title>
</head>
<style>
    table, th, td {
  border: 1px solid black;
}
</style>
<body>
    <h3 style="text-align: center; text-decoration: underline;"> {{ $title }} </h3>
    <p>Le Relevé de notes de l'étudiant:</p>
    <p> Code national de l'étudiant:  {{ $codedapogee }}</p>
    <p> NOM COMPLET: {{ $name }} </p>


    <table>
        <thead>
            <tr>
  <th>Module</th>
        <th>Note</th>
        <th>status</th>
            </tr>

        </thead>
        <tbody>
        <tr>
            <td>Genie logiciel</td>
            <td>11</td>
            <td>NV</td>
        </tr>
        <tr>
            <td>Java</td>
            <td>18</td>
            <td>V</td>
        </tr>
        </tbody>
    </table>

</body>
</html>
