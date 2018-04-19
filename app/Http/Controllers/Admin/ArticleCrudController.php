<?php namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ArticleRequest as StoreRequest;
use App\Http\Requests\ArticleRequest as UpdateRequest;

class ArticleCrudController extends CrudController {

    public function setup() {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Article");
        $this->crud->setRoute("admin/article");
        $this->crud->setEntityNameStrings('article', 'articles');

        /*
		|--------------------------------------------------------------------------
		| COLUMNS AND FIELDS
		|--------------------------------------------------------------------------
		*/

        // ------ CRUD COLUMNS
        $this->crud->addColumn([
            'name' => 'date',
            'label' => 'Date',
            'type' => 'date'
        ]);
        $this->crud->addColumn([
            'name' => 'status',
            'label' => "Status"
        ]);
        $this->crud->addColumn([
            'name' => 'title',
            'label' => "Title"
        ]);
        $this->crud->addColumn([
            'name' => 'featured',
            'label' => "Featured",
            'type' => "model_function",
            'function_name' => 'getFeaturedColumn'
        ]);
        $this->crud->addColumn([
            'label' => "Category",
            'type' => 'select',
            'name' => 'category_id',
            'entity' => 'category',
            'attribute' => 'name',
            'model' => "App\Models\Category"
        ]);

        // ------ CRUD FIELDS
        $this->crud->addField([    // TEXT
            'name' => 'title',
            'label' => 'Title',
            'type' => 'text',
            'placeholder' => 'Your title here'
        ]);
        $this->crud->addField([
            'name' => 'slug',
            'label' => "Slug (URL)",
            'type' => 'text',
            'hint' => 'Will be automatically generated from your title, if left empty.'
            // 'disabled' => 'disabled'
        ]);

        $this->crud->addField([    // TEXT
            'name' => 'date',
            'label' => 'Date',
            'type' => 'date',
            'value' => date('Y-m-d')
        ], 'create');
        $this->crud->addField([    // TEXT
            'name' => 'date',
            'label' => 'Date',
            'type' => 'date'
        ], 'update');

        $this->crud->addField([    // WYSIWYG
            'name' => 'content',
            'label' => 'Content',
            'type' => 'ckeditor',
            'placeholder' => 'Your textarea text here'
        ]);
        $this->crud->addField([    // Image
            'name' => 'image',
            'label' => 'Image',
            'type' => 'browse'
        ]);
        $this->crud->addField([    // SELECT
            'label' => "Category",
            'type' => 'select2',
            'name' => 'category_id',
            'entity' => 'category',
            'attribute' => 'name',
            'model' => "App\Models\Category"
        ]);
        $this->crud->addField([    // Select2Multiple = n-n
            'label' => 'Tags',
            'type' => 'select2_multiple',
            'name' => 'tags',
            'entity' => 'tags',
            'attribute' => 'name',
            'model' => "App\Models\Tag",
            'pivot' => true,
        ]);
        $this->crud->addField([    // ENUM
            'name' => 'status',
            'label' => "Status",
            'type' => 'enum'
        ]);
        $this->crud->addField([    // CHECKBOX
            'name' => 'featured',
            'label' => "Featured item",
            'type' => 'checkbox'
        ]);
    }

    public function store(StoreRequest $request)
    {
        return parent::storeCrud($request);
    }

    public function update(UpdateRequest $request)
    {
        return parent::updateCrud($request);
    }
}