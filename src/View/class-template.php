<?php

namespace HN\View;

/**
* Template View
*
* @author cmc <hello@cleberg.net>
*/
class Template
{
    /**
     * @var string
     */
    private $canonical_url;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $content;
    /**
     * @var false|string
     */
    private $current_year;

    public function __construct(string $canonical_url, string $page_description, string $page_title, string $content_col) {
		$this->canonical_url = $canonical_url;
		$this->description = $page_description;
		$this->title = $page_title;
		$this->content = $content_col;
		$this->current_year = date("Y");
	}

	public function echo_template() {
		// Get the template file
		$template_file = 'templates/template.html';
		$page = file_get_contents($template_file);

		// Replace the template variables
		$page = str_replace('{page_title}', $this->title, $page);
		$page = str_replace('{page_description}', $this->description, $page);
		$page = str_replace('{canonical_url}', $this->canonical_url, $page);
		$page = str_replace('{content}', $this->content, $page);
		$page = str_replace('{current_year}', $this->current_year, $page);

		// Echo the filled-out template
		echo $page;
	}
}

// EOF
	
