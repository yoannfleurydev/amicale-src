<?php

namespace AGIL\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * AgilUserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AgilUserRepository extends EntityRepository
{
    /**
     * recherche les utilisateurs soit par leur nom, leur prénom ou leur nom d'utilisateur
     * @param $keyword
     * @return array
     */
    public function searchByName($keyword) {

        $qb = $this->_em->createQueryBuilder()
            ->select('agil_user')
            ->from('AGILUserBundle:AgilUser', 'agil_user')
            ->where("agil_user.username LIKE :keyword OR agil_user.userLastName LIKE :keyword
            OR agil_user.userFirstName LIKE :keyword")
            ->setParameter('keyword', $keyword.'%')
            ->orderBy('agil_user.username', 'ASC')
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * recherche les utilisateurs par leur role puis, soit par leur nom, leur prénom ou leur nom d'utilisateur
     * @param $keyword
     * @param $role
     * @return array
     */
    public function searchByNameAndRole($keyword, $role) {

        $qb = $this->_em->createQueryBuilder()
            ->select('agil_user')
            ->from('AGILUserBundle:AgilUser', 'agil_user')
            ->where('agil_user.roles LIKE :roles')
            ->andwhere("agil_user.username LIKE :keyword OR agil_user.userLastName LIKE :keyword
            OR agil_user.userFirstName LIKE :keyword")
            ->setParameter('roles', '%"' .$role.'"%')
            ->setParameter('keyword', $keyword.'%')
            ->orderBy('agil_user.username', 'ASC')
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * recherche les utilisateurs avec le rôle de membre (user) soit par leur nom, leur prénom ou leur nom d'utilisateur
     * @param $keyword
     * @return array
     */
    public function searchByNameAndUsers($keyword)
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('agil_user')
            ->from('AGILUserBundle:AgilUser','agil_user')
            ->where('
            agil_user.roles NOT LIKE :roles AND
            agil_user.roles NOT LIKE :roles2 AND
            agil_user.roles NOT LIKE :roles3
            ')
            ->andwhere("agil_user.username LIKE :keyword OR agil_user.userLastName LIKE :keyword
            OR agil_user.userFirstName LIKE :keyword")
            ->setParameter('roles', '%"ROLE_SUPER_ADMIN"%')
            ->setParameter('roles2', '%"ROLE_MODERATOR"%')
            ->setParameter('roles3', '%"ROLE_ADMIN"%')
            ->setParameter('keyword', $keyword.'%')
        ;

        return $qb->getQuery()->getResult();
    }


    /**
     * @param string $role
     *
     * @return array
     */
    public function findByRole($role)
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('agil_user')
            ->from('AGILUserBundle:AgilUser','agil_user')
            ->where('agil_user.roles LIKE :roles')
            ->setParameter('roles', '%"' .$role.'"%')
            ->orderBy('agil_user.username', 'ASC')
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * retourne le nombre d'utilisateurs avec le role de membre uniquement
     * @param int $page
     * @param int $maxperpage
     * @return mixed
     */
    public function getCountUsers($page=1, $maxperpage=25)
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('count(agil_user.id)')
            ->from('AGILUserBundle:AgilUser','agil_user')
            ->where('
            agil_user.roles NOT LIKE :roles AND
            agil_user.roles NOT LIKE :roles2 AND
            agil_user.roles NOT LIKE :roles3
            ')
            ->setParameter('roles', '%"ROLE_SUPER_ADMIN"%')
            ->setParameter('roles2', '%"ROLE_MODERATOR"%')
            ->setParameter('roles3', '%"ROLE_ADMIN"%')
        ;

        $users_count = $qb->getQuery()->getSingleScalarResult();

        return $users_count;
    }

    /**
     * retourne le nombre d'utilisateurs excepté le super_admin
     * @param int $page
     * @param int $maxperpage
     * @return mixed
     */
    public function getCount($page=1, $maxperpage=25)
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('count(agil_user.id)')
            ->from('AGILUserBundle:AgilUser','agil_user')
            ->where('
            agil_user.roles NOT LIKE :roles
            ')
            ->setParameter('roles', '%"ROLE_SUPER_ADMIN"%')
        ;

        $users_count = $qb->getQuery()->getSingleScalarResult();

        return $users_count;
    }

    /**
     * Get the paginated list of published articles
     *
     * @param int $page
     * @param int $maxperpage
     * @return Paginator
     */
    public function getListUsers($page=1, $maxperpage=25)
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('agil_user')
            ->from('AGILUserBundle:AgilUser','agil_user')
            ->where('
            agil_user.roles NOT LIKE :roles AND
            agil_user.roles NOT LIKE :roles2 AND
            agil_user.roles NOT LIKE :roles3
            ')
            ->setParameter('roles', '%"ROLE_SUPER_ADMIN"%')
            ->setParameter('roles2', '%"ROLE_MODERATOR"%')
            ->setParameter('roles3', '%"ROLE_ADMIN"%')
            ->orderBy('agil_user.username', 'ASC')
        ;

        $qb->setFirstResult(($page-1) * $maxperpage)
            ->setMaxResults($maxperpage)->getQuery();

        return new Paginator($qb);
    }

    /**
     * Get the paginated list of published articles
     *
     * @param int $page
     * @param int $maxperpage
     * @param string $role
     * @return Paginator
     */
    public function getList($page=1, $maxperpage=25, $role)
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('agil_user')
            ->from('AGILUserBundle:AgilUser','agil_user')
            ->where('agil_user.roles LIKE :roles')
            ->setParameter('roles', '%"' .$role.'"%')
            ->orderBy('agil_user.username', 'ASC')
        ;

        $qb->getQuery()->setFirstResult(($page-1) * $maxperpage)
            ->setMaxResults($maxperpage);

        return new Paginator($qb);
    }
}
