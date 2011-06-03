<h1>Synonym groups List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($synonym_groups as $synonym_group): ?>
    <tr>
      <td><a href="<?php echo url_for('captcha/edit?id='.$synonym_group->getId()) ?>"><?php echo $synonym_group->getId() ?></a></td>
      <td><?php echo $synonym_group->getDescription() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('captcha/new') ?>">New</a>
