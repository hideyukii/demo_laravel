<?php


namespace App\Http\Controllers;


use App\Http\ViewModels\BackLog\BackLogIndexViewModel;
use App\Http\ViewModels\BackLog\UserInfoViewModel;
use App\Http\ViewModels\BackLog\UserStoryViewModel;
use App\Http\ViewModels\BackLog\UserPlanViewModel;
use Basic\Exception\NotFoundException;
use Illuminate\Http\Request;
use Scrum\Application\Service\BackLog\AddUserStoryCommand;
use Scrum\Application\Service\BackLog\AddUserPlanCommand;
use Scrum\Application\Service\BackLog\BackLogApplicationService;
use Scrum\Application\Service\BackLog\Query\BackLogQueryServiceInterface;
use Scrum\Application\Service\BackLog\Query\UserStorySummary;
use Scrum\Application\Service\BackLog\Query\UserPlanSummary;

class BackLogController extends Controller
{
    /**
     * UserInfoの一覧画面
     */
    public function index(BackLogQueryServiceInterface $backLogQueryService)
    {
        // ※UserInfoSummaryクエリデータを取得　※seqあり
        $summary = $backLogQueryService->getAllUserInfo();
        $userInfo = $summary['userInfo'];
        $userPlans = $summary['planSummaries'];
        $userStories = $summary['storySummaries'];

        $userInfoViewmodel = new UserInfoViewModel(
            $userInfo->getId()->getValue(),
            $userInfo->getName(),
            $userInfo->getStory(),
            $userInfo->getPlan(),
            $userInfo->getStart(),
            $userInfo->getEnd()
        );

        // ドメインモデルに変換、ある意味データをバリデーション ※seq削除 Summaryでprivateをpublic viewModelに代入
        $userPlanViewModels = collect($userPlans)->map(function (UserPlanSummary $summary) {
            return new UserPlanViewModel(
                $summary->id,
                $summary->story,
                $summary->author,
                $summary->start,
                $summary->end,
                $summary->estimation
            );
        })->all();

        // ドメインモデルに変換、ある意味データをバリデーション ※seq削除 Summaryでprivateをpublic viewModelに代入
        $userStoryViewModels = collect($userStories)->map(function (UserStorySummary $summary) {
            return new UserStoryViewModel(
                $summary->id,
                $summary->story,
                $summary->author,
                $summary->demo,
                $summary->estimation
            );
        })->all();

        // Laravelのarray-objectに変換
        $viewModel = new BackLogIndexViewModel($userInfoViewmodel, $userPlanViewModels, $userStoryViewModels);

        return view('backlog/index', compact('viewModel'));
    }

    // /**
    //  * UserStoryの一覧画面
    //  */
    // public function index_bu(BackLogQueryServiceInterface $backLogQueryService)
    // {
    //     // ※UserStorySummaryクエリデータを取得　※seqあり
    //     $userStories = $backLogQueryService->getAllUserStory();

    //     // ドメインモデルに変換、ある意味データをバリデーション ※seq削除
    //     $userStoriesViewModels = collect($userStories)->map(function (UserStorySummary $summary) {
    //         return new UserStoryViewModel(
    //             $summary->id,
    //             $summary->story,
    //             $summary->author,
    //             $summary->demo,
    //             $summary->estimation
    //         );
    //     })->all();

    //     // Laravelのarray-objectに変換
    //     $viewModel = new BackLogIndexViewModel($userStoriesViewModels);

    //     // 加工するならここ？

    //     return view("backlog/index", compact("viewModel"));
    // }

    /**
     * UserStoryの詳細画面
     */
    public function getUserStory(string $id, BackLogApplicationService $applicationService)
    {
        // ドメインの取得
        $story = $applicationService->getUserStory($id);

        if (is_null($story)) {
            throw new NotFoundException($id . " is notfound.");
        }

        // Laravel-objectに変換
        $viewModel = new UserStoryViewModel(
            $story->getId()->getValue(),
            $story->getStory(),
            $story->getAuthor()->getValue(),
            $story->getDemo(),
            $story->getEstimation()
        );

        return view("backlog/user-story/index", compact("viewModel"));
    }

    /**
     * UserStory入力画面
     */
    public function getAddUserStory()
    {
        return view("backlog/add-user-story");
    }

    /**
     * UserStoryの作成
     */
    public function postAddUserStory(Request $request, BackLogApplicationService $applicationService)
    {
        // バリデーション
        $request->validate([
            "story" => "required" 
        ]);

        // リクエストを変数に文字列でセット
        $story = $request->input("story");
        $demo = $request->input("demo");
        // コマンドにセット（整合性のチェック・ある意味バリデーション）
        $command = new AddUserStoryCommand($story, $demo);
        // UserStoryを追加
        $applicationService->addUserStory($command);

        return redirect()->action([BackLogController::class, "index"]);
    }

    /**
     * UserPlanの詳細画面
     */
    public function getUserPlan(string $id, BackLogApplicationService $applicationService)
    {
        // ドメインの取得
        $plan = $applicationService->getUserPlan($id);

        if (is_null($plan)) {
            throw new NotFoundException($id . " is notfound.");
        }

        // Laravel-objectに変換
        $viewModel = new UserPlanViewModel(
            $plan->getId()->getValue(),
            $plan->getPlan(),
            $plan->getAuthor()->getValue(),
            $plan->getStart(),
            $plan->getEnd(),
            $plan->getEstimation()
        );

        return view("backlog/user-plan/index", compact("viewModel"));
    }

    /**
     * UserPlan入力画面
     */
    public function getAddUserPlan()
    {
        return view("backlog/add-user-plan");
    }

    /**
     * UserPlanの作成
     */ 
    public function postAddUserPlan(Request $request, BackLogApplicationService $applicationService)
    {
        // バリデーション
        $request->validate([
            "plan" => "required" ,
            "month" => "required"
        ]);

        // リクエストを変数に文字列でセット
        $plan = $request->input("plan");
        $month = $request->input("month");

        // コマンドにセット（整合性のチェック・ある意味バリデーション）
        $command = new AddUserPlanCommand($plan, $month);
        // UserStoryを追加
        $applicationService->addUserPlan($command);

        return redirect()->action([BackLogController::class, "index"]);
    }


    public function estimateUserStory(string $id, Request $request, BackLogApplicationService $applicationService)
    {
        $estimation = $request->get("estimation");
        $applicationService->estimateUserStory($id, $estimation);
    }
}
