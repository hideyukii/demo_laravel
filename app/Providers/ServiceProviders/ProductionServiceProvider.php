<?php


namespace App\Providers\ServiceProviders;


use App\Lib\Context\AuthUserContext;
use App\Lib\Transaction\LaravelDbTransaction;
use App\Lib\RepositorySupports\FileRepositoryConfig;
use App\Providers\OriginalUserProvider;
use Authorization\Application\Service\Authenticate\AuthenticateService;
use Authorization\Application\Service\User\UserApplicationService;
use Authorization\DebugInfrastructure\Persistence\DebugUserFactory;
use Authorization\DebugInfrastructure\Persistence\FileUserRepository;
use Authorization\Domain\Users\UserFactoryInterface;
use Authorization\Domain\Users\UserRepositoryInterface;
use Basic\Transaction\Transaction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Hashing\BcryptHasher;
use Scrum\Application\Service\BackLog\BackLogApplicationService;
use Scrum\Application\Service\BackLog\Query\BackLogQueryServiceInterface;
use Scrum\Domain\Models\User\UserContextInterface;
use Scrum\Domain\Models\UserStories\UserStoryRepositoryInterface;
use Scrum\EloquentInfrastructure\Persistence\UserStories\EloquentUserStoryRepository;
use Scrum\Domain\Models\UserPlans\UserPlanRepositoryInterface;
use Scrum\EloquentInfrastructure\Persistence\UserPlans\EloquentUserPlanRepository;
use Scrum\EloquentInfrastructure\QueryServices\EloquentBackLogQueryService;

class ProductionServiceProvider implements Provider
{
    /** @var Application */
    private $app;

    /**
     * LocalServiceProvider constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function register()
    {
        $this->registerLibrary();
        $this->registerProviders();
        $this->registerUtilities();
        $this->registerApplications();
        $this->registerInfrastructures();
    }

    function boot()
    {
        $debugPersistenceDirectoryFullPath = storage_path("debug\\persistence");
        FileRepositoryConfig::$basicDirectoryFullPath = $debugPersistenceDirectoryFullPath;
    }

    private function registerLibrary()
    {
        $this->app->bind(Transaction::class, LaravelDbTransaction::class);
        $this->app->bind(UserContextInterface::class, AuthUserContext::class);
    }

    private function registerProviders()
    {
        $this->app->bind(OriginalUserProvider::class);
    }

    private function registerUtilities()
    {
        $this->app->bind(Hasher::class, BcryptHasher::class);
    }

    private function registerApplications()
    {
        $this->app->bind(BackLogApplicationService::class);

        // Auth
        $this->app->bind(AuthenticateService::class);
        $this->app->bind(UserApplicationService::class);
    }

    private function registerInfrastructures()
    {
        $this->app->bind(
            BackLogQueryServiceInterface::class,
            EloquentBackLogQueryService::class
        );
        $this->app->bind(UserStoryRepositoryInterface::class, EloquentUserStoryRepository::class);
        $this->app->bind(UserPlanRepositoryInterface::class, EloquentUserPlsnRepository::class);

        // Auth
        $this->app->bind(UserFactoryInterface::class, DebugUserFactory::class);
        $this->app->bind(UserRepositoryInterface::class, FileUserRepository::class);
    }
}
