<?php

defined('_JEXEC') or exit();

class Dmnd_seoControllerList extends JControllerAdmin {

	public function __construct($config = array())
    {
        parent::__construct($config);

        $this->registerTask('savelist', 'saveList');
    }

    public function saveMap()
    {
        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // $ordering    = $this->input->get('ordering', array(), 'array');

        // // Get the model.
        // $model = $this->getModel();

        // // Change the state of the records.
        // if (!$model->savemap($ordering))
        // {
        //     JError::raiseWarning(500, $model->getError());
        // }

        $this->setRedirect('index.php?option=com_dmnd_seo&view=list');
    }

    public function generateMap()
    {
        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Get the model.
        $model = $this->getModel();

        // Change the state of the records.
        if (!$model->generatemap())
        {
            JError::raiseWarning(500, $model->getError());
        }

        $this->setRedirect('index.php?option=com_dmnd_seo&view=list');
    }

	public function getModel($name = 'Item', $prefix = 'Dmnd_seoModel', $config = array()) {
		return parent::getModel($name, $prefix, $config);
	}
}