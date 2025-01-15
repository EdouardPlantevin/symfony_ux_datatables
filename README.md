# Symfony UX DataTables

**Une intégration de DataTables.net en PHP pour Symfony, car moins de JavaScript, c'est mieux pour la santé mentale !**  
[DataTables.net](https://datatables.net/) est un puissant outil pour afficher des tables interactives.

---

## Installation

Pour commencer, ajoutez cette configuration dans votre `composer.json` :

```json
{
    "require": {
        "symfony/ux-datatables": "dev-main"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/EdouardPlantevin/symfony_ux_datatables.git"
        }
    ]
}
```

Ensuite, installez la dépendance avec Composer : 

```bash
composer install
```

---

## Utilisation

### Contrôleur : Exemple d'implémentation

Voici un exemple d'utilisation dans un contrôleur Symfony : 

```php
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\DataTables\Builder\DataTableBuilderInterface;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(DataTableBuilderInterface $builder): Response
    {
        $table = $builder->createDataTable('tableInvoices');

        $table->setOptions([
            'ajax' => [
                'url' => $this->generateUrl('app_ajax_data'),
                'dataSrc' => '',
            ],
            'columns' => [
                ['title' => 'ID'],
                ['title' => 'Montant'],
                ['title' => 'Date'],
            ],
        ]);

        return $this->render('home/index.html.twig', [
            'table' => $table,
        ]);
    }

    #[Route('/ajax/data', name: 'app_ajax_data')]
    public function ajaxData(): Response
    {
        $invoices = [];

        for ($i = 0; $i < 1000; $i++) {
            $invoices[] = [
                $i + 1,
                rand(100, 1000),
                (new \DateTime())->modify(sprintf('-%d days', $i))->format('Y-m-d'),
            ];
        }

        return $this->json($invoices);
    }
}
```

---

### Vue Twig : Intégration de la DataTable

Dans votre fichier Twig, vous pouvez rendre la table très simplement :

```twig
{% extends 'base.html.twig' %}

{% block title %}Je cherche un job, si jamais ça vous intéresse{% endblock %}

{% block body %}
<div class="example-wrapper">
    <h1>Easy DataTable</h1>
    {{ render_datatable(table) }}
</div>
{% endblock %}
```

---

## Documentation Complémentaire

Pour personnaliser votre table et découvrir toutes les fonctionnalités de DataTables.net, consultez leur [documentation officielle](https://datatables.net/).

---

## Merci à [Pentiminax](https://www.youtube.com/@Pentiminax) de nous montrer la voie
