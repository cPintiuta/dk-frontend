<?php

declare(strict_types=1);

namespace Frontend\Plugin;

use Dot\Controller\Exception\RuntimeException;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\Form\Factory\FormAbstractServiceFactory;
use Dot\Controller\Plugin\PluginInterface;
use Dot\Form\FormElementManager;
use Laminas\Form\Form;
use Psr\Container\ContainerInterface;

class FormsPlugin implements PluginInterface
{
    protected FormElementManager $formElementManager;
    protected ?FlashMessengerInterface $flashMessenger;

    protected ContainerInterface $container;

    public function __construct(
        FormElementManager $formManager,
        ContainerInterface $container,
        FlashMessengerInterface $flashMessenger = null
    ) {
        $this->formElementManager = $formManager;
        $this->flashMessenger = $flashMessenger;
        $this->container = $container;
    }

    public function __invoke(string $name = null)
    {
        if (is_null($name)) {
            return $this;
        }

        $result = null;
        // check the container first, in case there is a form to get through the abstract factory
        $abstractFormName = FormAbstractServiceFactory::PREFIX . '.' . $name;
        if ($this->container->has($abstractFormName)) {
            $result = $this->container->get($abstractFormName);
        } elseif ($this->formElementManager->has($name)) {
            $result = $this->formElementManager->get($name);
        }

        if (!$result) {
            throw new RuntimeException(
                "Form, fieldset or element with name $result could not be created. ' .
                'Are you sure you registered it in the form manager?"
            );
        }

        if ($result instanceof Form) {
            $this->restoreState($result);
        }

        return $result;
    }

    public function restoreState(Form $form): void
    {
        if ($this->flashMessenger instanceof FlashMessengerInterface) {
            $dataKey = $form->getName() . '_data';
            $messagesKey = $form->getName() . '_messages';

            $data = $this->flashMessenger->getData($dataKey) ?: [];
            $messages = $this->flashMessenger->getData($messagesKey) ?: [];

            $form->setData($data);
            $form->setMessages($messages);
        }
    }

    public function saveState(Form $form): void
    {
        if ($this->flashMessenger instanceof FlashMessengerInterface) {
            $dataKey = $form->getName() . '_data';
            $messagesKey = $form->getName() . '_messages';

            $this->flashMessenger->addData($dataKey, $form->getData(FormInterface::VALUES_AS_ARRAY));
            $this->flashMessenger->addData($messagesKey, $form->getMessages());
        }
    }

    public function getMessages(Form $form): array
    {
        return $this->processFormMessages(
            $form->getMessages()
        );
    }

    protected function processFormMessages(array $formMessages): array
    {
        $messages = [];
        foreach ($formMessages as $message) {
            if (is_array($message)) {
                foreach ($message as $m) {
                    if (is_string($m)) {
                        $messages[] = $m;
                    } elseif (is_array($m)) {
                        $messages = array_merge($messages, $this->processFormMessages($m));
                    }
                }
            } elseif (is_string($message)) {
                $messages[] = $message;
            }
        }

        return $messages;
    }
}
