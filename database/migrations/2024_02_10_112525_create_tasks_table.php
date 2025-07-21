
     <?php

        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;

        return new class extends Migration
        {
            /**
             * Run the migrations.
             */
            public function up(): void
            {
                // Drop the incorrect tasks table structure
                Schema::dropIfExists('tasks');

                // Create the correct tasks table
                Schema::create('tasks', function (Blueprint $table) {
                    $table->id();
                    $table->string('title');
                    $table->text('description');
                    $table->dateTime('start_date_time');
                    $table->dateTime('end_date_time');
                    $table->enum('status', ['Pending', 'In Progress', 'Completed'])->default('Pending');
                    $table->enum('priority', ['Low', 'Medium', 'High', 'Critical'])->default('Low');
                    $table->integer('project_id')->nullable();
                    $table->integer('user_id')->nullable();
                    $table->string('image_path')->nullable();
                    $table->json('message_ids')->nullable();
                    $table->timestamps();
                });

                // Ensure task_messages table exists

            }

            /**
             * Reverse the migrations.
             */
            public function down(): void
            {

                Schema::dropIfExists('tasks');
            }
        };
