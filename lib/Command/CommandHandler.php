<?php
/**
 * Created by PhpStorm.
 * User: mariogiustiniani
 * Date: 18/09/14
 * Time: 15:17
 */

namespace Manticora\Common\Command;



class CommandHandler {

    private $validator;
    private $eventDispatcher;
    private $useCases = array();

    /*public function __construct(Validator $validator,
                                EventDispatcher $eventDispatcher)
    {
        $this->validator = $validator;
        $this->eventDispatcher = $eventDispatcher;
    }**/

    public function registerCommands(array $useCases)
    {
        foreach ($useCases as $useCase) {


            if ($useCase instanceof UseCaseInterface) {
                $this->useCases[join('', array_slice(explode('\\',get_class($useCase)), -1)).'Command'] = $useCase;
            } else {
                throw new \LogicException('CommandHandler registerCommands expects an array of UseCase');
            }
        }
    }
    /**
     * @param $command
     * @return Response
     */
    public function execute($command)
    {
        $this->exceptionIfCommandNotManaged($command);

       // try {

         //   $this->eventDispatcher->notify(Events::PRE_COMMAND, new PreCommandEvent($command));

           // $errors = $this->validator->validate($command);
           // if ($errors->count() > 0) {
             //   throw new ValidationException($errors);
            //}

            $result = $this->useCases[join('',array_slice(explode('\\',get_class($command)), -1))]->run($command);
           // $response = new Response($result);

           // $this->eventDispatcher->notify(Events::POST_COMMAND, new PostCommandEvent($command, $response));

           // return $response;

      //  } catch (DomainException $e) {
           // $this->eventDispatcher->notify(Events::EXCEPTION, new ExceptionEvent($command, $e));
        //    return new Response($e->getMessage());
        //} catch (ValidationException $e) {
           // $this->eventDispatcher->notify(Events::EXCEPTION, new ExceptionEvent($command, $e));
          //  return new Response($errors);
       // }
        return $result;
    }

    /**
     * @param $command
     * @throws \LogicException
     */
    private function exceptionIfCommandNotManaged($command)
    {
        $commandClass =join('',array_slice(explode('\\',get_class($command)), -1));


        if (!array_key_exists($commandClass, $this->useCases)) {
            throw new \LogicException($commandClass . ' is not a managed command');
        }
    }
} 